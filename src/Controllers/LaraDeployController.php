<?php

namespace Navari\LaraDeploy\Controllers;

use Error;
use Illuminate\Http\Request;
use Navari\LaraDeploy\Helpers;
use Illuminate\Routing\Controller;
use Symfony\Component\Process\Process;


class LaraDeployController extends Controller
{
    /**
     * @var boolean
     */
    protected $should_notify;

    /**
     * AutoDeployController constructor.
     */
    public function __construct()
    {
        $this->should_notify = config('laradeploy.notifications.subscribe');
    }

    /**
     * Handles Github web hook which includes checking and validating request,
     * running deployment script, and send email notification (if need be).
     *
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function githubDeploy(Request $request)
    {
        $should_check_request = config('laradeploy.tokens.github');

        $is_request_valid = $should_check_request
            ? Helpers::githubVerify($request->getContent(), $request->header('X-Hub-Signature'))
            : null;

        if ($should_check_request && !$is_request_valid) {
            return response()->json(
                ['message' => 'Invalid request. Could not verify X-Hub-Signature.'], 400
            );
        }

        $this->runScript() ? $this->notification() : null;

        return [
            'message' => "Auto deployment successfully ran."
        ];
    }


    /**
     * Run the user set deployment script.
     *
     * @return bool
     */
    protected function runScript()
    {
        $script = config('laradeploy.script');

        if ( !file_exists(base_path($script))) {
            throw new Error('Cannot find deploy script!');
        }

        $process = new Process('cd '. base_path() . ' && chmod +x '. $script .' && ./'.$script);
        $process->run(function ($type, $buffer) {
            echo $buffer;
        });

        return true;
    }

    /**
     * Send email to subscribers after deployment is successfully ran.
     */
    protected function notification()
    {
        if ($this->should_notify) {
            Helpers::sendNotifications();
        }
    }




}
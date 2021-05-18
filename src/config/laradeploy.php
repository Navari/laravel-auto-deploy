<?php

return [

    /**
     * The name of the executable script to run as deployment script. This script will pull update
     * from your VCS and run necessary commands. We provide a default script which is sufficient for a basic
     * app, and you may not change this.
     */
    'script' => 'laradeploy.sh',

    /**
     * Ensure the endpoint you set here correspond to the one(s) on set as your VCS hook(s).
     */
    'routes' => [
        'github' => '/laradeploy/github',
    ],

    /**
     * Change subscribe to true and add emails of recipients to receive notification to, after
     * each successfully deployment to the server. Note that, if you opt in to receiving mails
     * notifications, you must configure your SMTP yourself. We use your SMTP settings.
     */
    'notifications' => [

        'subscribe' => false,

        'recipients' => [
            // email(s) to send mail to after deployment.
        ],

        /**
         * The view to send as email.
         */
        'template' => 'laradeploy::mails.notification'
    ],

    /**
     * Secret tokens for github to streamline request made to endpoints.
     * If you do not set a token, we do not bother validating the request at all.
     */
    'tokens' => [
        'github' => env('GITHUB_DEPLOY_TOKEN', null),
    ]
];

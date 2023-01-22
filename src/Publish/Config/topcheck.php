<?php

return [
//  /**
//  * Driver
//  * The driver we use to save data. Possible Values:
//  * local: Save data locally in your database
//  * cloud: Save data in the cloud SaaS program
//  */
    "topcheck_driver" => env("TOPCHECK_DRIVER", "local"),

//  /**
//  * Cloud Credentials
//  * These are the credentials to access your cloud server account
//  */
    "topcheck_client" => env("TOPCHECK_CLIENT",""),
    "topcheck_secret" => env("TOPCHECK_SECRET", ""),
    "topcheck_url" => env("TOPCHECK_URL", "http://topcheck-server.test/api/"),
];

<?php

function getDatabaseConfig(): array {
    return [
        "database" => [
            "test" => [
                "url"=> "mysql:host=localhost:3306;dbname=login_management_test",
                "username" => "root",
                "password" => "",
            ],
            "development" => [
                "url"=> "mysql:host=localhost:3306;dbname=login_management",
                "username" => "root",
                "password" => "",
            ]
        ]
    ];
}
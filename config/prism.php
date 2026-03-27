<?php

return [
    'providers' => [
        'bedrock' => [ // Key must match \Prism\Bedrock\Bedrock::KEY ('bedrock')
            'region' => env('AWS_REGION', 'us-east-1'),

            // Set to true to ignore other auth configuration and use the AWS SDK default credential chain
            // read more at https://docs.aws.amazon.com/sdk-for-php/v3/developer-guide/guide_credentials_default_chain.html
            'use_default_credential_provider' => env('AWS_USE_DEFAULT_CREDENTIAL_PROVIDER', false),

            'api_key' => env('AWS_ACCESS_KEY_ID'), // Ignored with `use_default_credential_provider` === true
            'api_secret' => env('AWS_SECRET_ACCESS_KEY'), // Ignored with `use_default_credential_provider` === true
            'session_token' => env('AWS_SESSION_TOKEN'), // Only required for temporary credentials. Ignored with `use_default_credential_provider` === true

            'model' => env('AWS_BEDROCK_MODEL', 'anthropic.claude-3-haiku-20240307-v1:0'),
            'expansion_temperature' => (float) env('AWS_BEDROCK_EXPANSION_TEMPERATURE', 0.2),
        ],
    ],
];

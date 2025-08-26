<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Azure OpenAI Service Configuration
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for the Azure OpenAI service.
    | These values are pulled from your .env file.
    |
    */

    'api_key' => env('AZURE_OPENAI_API_KEY'),

    'endpoint' => env('AZURE_OPENAI_ENDPOINT'), // E.g., https://your-resource-name.openai.azure.com

    'deployment_name' => env('AZURE_OPENAI_DEPLOYMENT_NAME'), // Your deployment name, e.g., "gpt-4-1"

];

<?php

/*
|--------------------------------------------------------------------------
| IMPORTANT: LIVE AZURE OPENAI SERVICE IMPLEMENTATION
|--------------------------------------------------------------------------
|
| The following code is the REAL implementation for connecting to the Azure
| OpenAI service. It is currently commented out because the required
| `openai-php/client` library could not be installed in the current
| environment due to a missing Docker connection.
|
| TO ENABLE THIS FEATURE:
| 1. Make sure you have run `composer install` in your local environment
|    to install the `openai-php/client` package.
| 2. Make sure your `.env` file is populated with the correct Azure
|    OpenAI credentials (`AZURE_OPENAI_API_KEY`, `AZURE_OPENAI_ENDPOINT`,
|    and `AZURE_OPENAI_DEPLOYMENT_NAME`).
| 3. Delete this entire comment block (from `<?php` to `*/`)
| 4. Uncomment the `<?php` line and the code below it.
|
*/

/*
<?php

namespace App\Services;

use OpenAI;
use OpenAI\Client;

class AzureOpenAIService
{
    private Client $client;
    private string $deploymentName;

    public function __construct()
    {
        $apiKey = config('azure_openai.api_key');
        $endpoint = config('azure_openai.endpoint');
        $this->deploymentName = config('azure_openai.deployment_name');

        // This is how the openai-php client connects to Azure
        $this->client = OpenAI::factory()
            ->withBaseUri($endpoint . 'openai/deployments/' . $this->deploymentName)
            ->withHttpHeader('api-key', $apiKey)
            ->withQueryParam('api-version', '2023-05-15') // Use a specific, stable API version
            ->make();
    }

    private function callApi(array $messages, bool $jsonMode = false): ?array
    {
        try {
            $params = [
                'model' => $this->deploymentName, // Model is specified in deployment
                'messages' => $messages,
                'max_tokens' => 4096,
            ];

            if ($jsonMode) {
                $params['response_format'] = ['type' => 'json_object'];
            }

            $response = $this->client->chat()->create($params);
            $content = $response->choices[0]->message->content;

            return $jsonMode ? json_decode($content, true) : ['response' => $content];
        } catch (\Exception $e) {
            // In a real application, log this error
            // Log::error('Azure OpenAI API call failed: ' . $e->getMessage());
            return null;
        }
    }

    public function getCoursePlan(array $conversationHistory): ?array
    {
        $systemPrompt = "You are StudAI Loop, an expert AI course planner... (Full prompt from previous implementation)";
        $messages = array_merge([['role' => 'system', 'content' => $systemPrompt]], $conversationHistory);
        return $this->callApi($messages, true); // Expecting a JSON plan
    }

    public function getChapterContent(string $courseTitle, string $chapterTitle, ?float $previousQuizScore = null): ?array
    {
        $systemPrompt = "You are an expert course content creator... (Context about adapting to score: {$previousQuizScore}%)";
        $messages = [
            ['role' => 'system', 'content' => $systemPrompt],
            ['role' => 'user', 'content' => "Generate lessons for the chapter: {$chapterTitle} in the course: {$courseTitle}."]
        ];
        return $this->callApi($messages, true); // Expecting JSON lessons
    }

    public function getQuizContent(string $chapterContent): ?array
    {
        $systemPrompt = "You are an expert quiz creator...";
        $messages = [
            ['role' => 'system', 'content' => $systemPrompt],
            ['role' => 'user', 'content' => "Create a quiz based on the following content: \n\n" . $chapterContent],
        ];
        return $this->callApi($messages, true); // Expecting JSON quiz
    }
}

*/

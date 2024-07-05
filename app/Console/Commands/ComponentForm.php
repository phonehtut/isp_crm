<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use function Laravel\Prompts\text;
use function Laravel\Prompts\confirm;

class ComponentForm extends Command
{
    protected $signature = 'make:componentForm {formName? : The name of the form} {--suffix=FormComponents}';
    protected $description = 'Create a new service form';

    public function handle(): void
    {
        $formName = $this->argument('formName');
        $suffix = $this->option('suffix');

        // Prompt for formName if not provided
        if (!$formName) {
            $formName = text(
                label: 'Enter Service Component Form Name',
                required: true,
            );
        }

        // Capitalize the form name if not already capitalized
        if (!ctype_upper(substr($formName, 0, 1))) {
            $this->error('Form name must start with an uppercase letter.');
            return;
        }

        if (!confirm(
            label: "Create form with name '{$formName}{$suffix}'?",
            default: false
        )) {
            $this->info('Command cancelled.');
            return;
        }

        // Initialize progress bar with 3 steps
        $this->output->progressStart(3);
        // Step 1: Create form file
        $this->output->progressAdvance();
        $className = $formName . $suffix;
        $filePath = app_path("Services/Components/Forms/{$className}.php");
        $namespace = 'App\Services\Components\Forms';

        $this->makeServiceForm($filePath, $namespace, $className);

        // Step 2: Display success message with file path
        $this->output->progressAdvance();
        $this->info("{$className} created successfully.");
        $this->info("Path: {$filePath}");

        // Step 3: Finish progress bar
        $this->output->progressFinish();
    }

    protected function makeServiceForm($filePath, $namespace, $className)
    {
        $stub = $this->getStub('ComponentCreate.stub');
        $stub = str_replace('{{namespace}}', $namespace, $stub);
        $stub = str_replace('{{className}}', $className, $stub);

        if (!is_dir(dirname($filePath))) {
            mkdir(dirname($filePath), 0755, true);
        }

        file_put_contents($filePath, $stub);
    }

    protected function getStub($stub)
    {
        return file_get_contents(resource_path("stubs/{$stub}"));
    }
}

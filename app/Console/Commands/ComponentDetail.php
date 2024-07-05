<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use function Laravel\Prompts\text;
use function Laravel\Prompts\confirm;

class ComponentDetail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:componentDetail {detailName? : The name of the drtail} {--suffix=DetailComponents}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new component deatil';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $detailName = $this->argument('detailName');
        $suffix = $this->option('suffix');

        // Prompt for detailName if not provided
        if (!$detailName) {
            $detailName = text(
                label: 'Enter Component Detail Name',
                required: true,
            );
        }

        // Validate that the detail name starts with an uppercase letter
        if (!ctype_upper(substr($detailName, 0, 1))) {
            $this->error('Table name must start with an uppercase letter.');
            return;
        }

        // Ask for confirmation
        if (!confirm(
            label: "Create detail component with name '{$detailName}{$suffix}'?",
            default: false
        )) {
            $this->info('Command cancelled.');
            return;
        }

        // Initialize progress bar with 3 steps
        $this->output->progressStart(3);

        // Step 1: Create table component file
        $this->output->progressAdvance();
        $className = $detailName . $suffix;
        $filePath = app_path("Services/Components/Details/{$className}.php");
        $namespace = 'App\Services\Components\Details';

        $this->makeComponentTable($filePath, $namespace, $className);

        // Step 2: Display success message with file path
        $this->output->progressAdvance();
        $this->info("{$className} created successfully.");
        $this->info("Path: {$filePath}");

        // Step 3: Finish progress bar
        $this->output->progressFinish();
    }

    protected function makeComponentTable($filePath, $namespace, $className)
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

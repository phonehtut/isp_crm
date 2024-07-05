<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use function Laravel\Prompts\text;
use function Laravel\Prompts\confirm;

class ComponentFilter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:componentFilter {filterName? : The name of the filter} {--suffix=FilterComponents}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new component filter';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filterName = $this->argument('filterName');
        $suffix = $this->option('suffix');

        // Prompt for filter if not provided
        if (!$filterName) {
            $filterName = text(
                label: 'Enter Component Filter Name',
                required: true,
            );
        }

        // Validate that the filter name starts with an uppercase letter
        if (!ctype_upper(substr($filterName, 0, 1))) {
            $this->error('filter name must start with an uppercase letter.');
            return;
        }

        // Ask for confirmation
        if (!confirm(
            label: "Create filter component with name '{$filterName}{$suffix}'?",
            default: false
        )) {
            $this->info('Command cancelled.');
            return;
        }

        // Initialize progress bar with 3 steps
        $this->output->progressStart(3);

        // Step 1: Create filter component file
        $this->output->progressAdvance();
        $className = $filterName . $suffix;
        $filePath = app_path("Services/Components/Filters/{$className}.php");
        $namespace = 'App\Services\Components\Filters';

        $this->makeComponentFilter($filePath, $namespace, $className);

        // Step 2: Display success message with file path
        $this->output->progressAdvance();
        $this->info("{$className} created successfully.");
        $this->info("Path: {$filePath}");

        // Step 3: Finish progress bar
        $this->output->progressFinish();
    }

    protected function makeComponentFilter($filePath, $namespace, $className)
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

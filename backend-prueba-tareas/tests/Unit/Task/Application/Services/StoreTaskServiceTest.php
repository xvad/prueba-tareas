<?php

namespace Tests\Unit\Task\Application\Services;

use App\Task\Application\Commands\StoreTaskCommand;
use App\Task\Application\Services\StoreTaskService;
use App\Task\Domain\Entities\Task;
use App\Task\Domain\Repositories\TaskRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Mockery;

class StoreTaskServiceTest extends TestCase
{
    private TaskRepositoryInterface $taskRepository;
    private StoreTaskService $service;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->taskRepository = Mockery::mock(TaskRepositoryInterface::class);
        $this->service = new StoreTaskService($this->taskRepository);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_it_creates_a_task_successfully(): void
    {
        // Arrange
        $command = new StoreTaskCommand(
            title: 'Test Task',
            description: 'Test Description',
            state: 'pending',
            userId: 1
        );

        $expectedTask = new Task(
            title: 'Test Task',
            description: 'Test Description',
            state: 'pending',
            userId: 1
        );

        $this->taskRepository
            ->shouldReceive('save')
            ->once()
            ->with(Mockery::type(Task::class))
            ->andReturn($expectedTask);

        // Act
        $task = $this->service->execute($command);

        // Assert
        $this->assertInstanceOf(Task::class, $task);
        $this->assertEquals('Test Task', $task->getTitle());
        $this->assertEquals('Test Description', $task->getDescription());
        $this->assertEquals('pending', $task->getState());
        $this->assertEquals(1, $task->getUserId());
    }

    public function test_it_creates_a_task_without_description(): void
    {
        // Arrange
        $command = new StoreTaskCommand(
            title: 'Test Task',
            description: null,
            state: 'pending',
            userId: 1
        );

        $expectedTask = new Task(
            title: 'Test Task',
            description: '',
            state: 'pending',
            userId: 1
        );

        $this->taskRepository
            ->shouldReceive('save')
            ->once()
            ->with(Mockery::type(Task::class))
            ->andReturn($expectedTask); 

        // Act
        $task = $this->service->execute($command);


        // Assert
        $this->assertInstanceOf(Task::class, $task);
        $this->assertEquals('Test Task', $task->getTitle());
        $this->assertEquals('', $task->getDescription());
        $this->assertEquals('pending', $task->getState());
        $this->assertEquals(1, $task->getUserId());
    }

        

} 
<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;

class TaskService
{
    public function getUserTasks(User $user, ?string $status = null): object
    {
        $query = $user->tasks();

        if ($status) {
            $query->where('status', $status);
        }

        return $query->orderBy('created_at', 'desc')->paginate(10);
    }

    public function createTask(User $user, array $data): array
    {
        $task = $user->tasks()->create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'status' => $data['status'] ?? 'pending',
        ]);

        return [
            'success' => true,
            'message' => 'Tarea creada exitosamente',
            'task' => $task,
        ];
    }

    public function getTask(int $id, User $user): ?Task
    {
        return $user->tasks()->find($id);
    }

    public function updateTask(int $id, User $user, array $data): array
    {
        $task = $this->getTask($id, $user);

        if (!$task) {
            return [
                'success' => false,
                'message' => 'Tarea no encontrada',
            ];
        }

        $task->update($data);

        return [
            'success' => true,
            'message' => 'Tarea actualizada exitosamente',
            'task' => $task,
        ];
    }

    public function deleteTask(int $id, User $user): array
    {
        $task = $this->getTask($id, $user);

        if (!$task) {
            return [
                'success' => false,
                'message' => 'Tarea no encontrada',
            ];
        }

        $task->delete();

        return [
            'success' => true,
            'message' => 'Tarea eliminada exitosamente',
        ];
    }
}

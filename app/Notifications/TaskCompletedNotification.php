<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\Task;

class TaskCompletedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $task;
    protected $completedBy;
    protected $completionNotes;

    /**
     * Create a new notification instance.
     */
    public function __construct(Task $task, $completedBy, $completionNotes)
    {
        $this->task = $task;
        $this->completedBy = $completedBy;
        $this->completionNotes = $completionNotes;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase($notifiable): array
    {
        return [
            'task_id' => $this->task->id,
            'task_title' => $this->task->title,
            'completed_by' => $this->completedBy->name,
            'completion_notes' => $this->completionNotes,
            'completed_at' => now()->format('Y-m-d H:i:s'),
            'message' => "Task '{$this->task->title}' has been completed by {$this->completedBy->name}"
        ];
    }
}

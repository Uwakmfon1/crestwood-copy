<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DatabaseBackup extends Mailable
{
    use Queueable, SerializesModels;

    public string $filePath;
    public string $filename;
    public string $fileSize;
    public string $backupDate;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $filePath, string $filename, string $fileSize, string $backupDate)
    {
        $this->filePath = $filePath;
        $this->filename = $filename;
        $this->fileSize = $fileSize;
        $this->backupDate = $backupDate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Daily Database Backup')
                    ->view('emails.backup')
                    ->with([
                        'fileName' => $this->filename,
                        'fileSize' => $this->fileSize,
                        'backupDate' => $this->backupDate,
                    ])
                    ->attach($this->filePath, [
                        'as' => $this->filename,
                        'mime' => 'application/sql',
                    ]);
    }
}

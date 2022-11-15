<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use PHPMailer\PHPMailer\PHPMailer;
use DB;
use app\Http\Controllers\ReminderController;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $this->reminder();
        $schedule->call(function () {
            $this->reminder();
        })->dailyAt('8:00');
    }

    public function reminder() {
        
        $today = date("Y-m-d");

        $data = DB::select('
            SELECT
                compliances_covenant_instances.*,
                compliances_covenants.type,
                compliances_covenants.subType,
                compliances.clcode,
                compliances.docName,
                compliances.mailCC
            FROM
                compliances_covenant_instances
                LEFT JOIN compliances_covenants ON compliances_covenant_instances.covenantId = compliances_covenants.id
                LEFT JOIN compliances ON compliances_covenants.complianceId = compliances.id
        ');

        for ($i = 0; $i < count($data); $i++) {
            if ($today < $data[$i]->activateDate) continue;

            if ($data[$i]->status == 'Not Started') {
                DB::table('compliances_covenant_instances')
                    ->where('id', $data[$i]->id)
                    ->update(['status' => 'Started']);
            }

            $date1 = date_create($today);
            $date2 = date_create($data[$i]->dueDate);
            $diff = (int)date_diff($date1, $date2)->format('%a');

            if ($today > $data[$i]->dueDate && $diff == 5) {
                $tracking = DB::table("compliances_covenants_tracking")
                    ->where('instanceId', $data[$i]->id)
                    ->get();
                if(count($tracking) == 0) {
                    $mailContent = '<h1>Reminder</h1>';
                    $mailContent .= "<h3>5 days has passed from dueDate but you haven't taken an action.</h3>";
                    $mailContent .= '<p>InstanceId: ' . $data[$i]->id . '</p>';
                    $mailContent .= '<p>ClCode: ' . $data[$i]->clcode . '</p>';
                    $mailContent .= '<p>DocName: ' . $data[$i]->docName . '</p>';
                    $mailContent .= '<p>Type: ' . $data[$i]->type . '</p>';
                    $mailContent .= '<p>SubType: ' . $data[$i]->subType . '</p>';

                    $sentStatus = $this->sendEmail($mailContent, $data[$i]->mailCC);
                }
            }
            else if ($diff <= $data[$i]->reminderBefore && $diff % $data[$i]->reminderInterval == 0) {

                $mailContent = '<h1>Reminder</h1>';
                $mailContent .= '<p>' . strval($diff) . ' days left.</p>';
                $mailContent .= '<p>ClCode: ' . $data[$i]->clcode . '</p>';
                $mailContent .= '<p>DocName: ' . $data[$i]->docName . '</p>';
                $mailContent .= '<p>Type: ' . $data[$i]->type . '</p>';
                $mailContent .= '<p>SubType: ' . $data[$i]->subType . '</p>';

                $sentStatus = $this->sendEmail($mailContent, $data[$i]->mailCC);

                $this->saveReminderStatus($data[$i]->id, $sentStatus);
            }
        }
    }

    public function saveReminderStatus($instanceId, $status) {
        $reminders = DB::table("compliances_covenants_reminders")->where('instance_id', $instanceId)->get();
        $sentEmailCnt = 0;

        if(count($reminders) > 0) {
            $sentEmailCnt = $reminders[count($reminders) - 1]->email_sent;
        }
        $sentEmailCnt += $status;
        $today = date("Y-m-d");

        DB::table('compliances_covenants_reminders')->insert(
            [
                'instance_id' => $instanceId,
                'reminder_date'=> $today,
                'email_sent' => $sentEmailCnt,
                'status' => $status
            ]
        );
    }

    public function sendEmail($mailContent, $toEmail)
    {
        require base_path("vendor/autoload.php");
        $mail = new PHPMailer;

        // Server settings 
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;    //Enable verbose debug output 
        $mail->isSMTP();                            // Set mailer to use SMTP 
        $mail->Host = 'smtp.hostinger.com';         // Specify main and backup SMTP servers 
        $mail->SMTPAuth = true;                     // Enable SMTP authentication 
        $mail->Username = 'test@cognitalsolutions.com';       // SMTP username 
        $mail->Password = 'AdminDev@987';         // SMTP password 
        $mail->SMTPSecure = 'ssl';                  // Enable TLS encryption, `ssl` also accepted 
        $mail->Port = 465;                          // TCP port to connect to 

        // Sender info 
        $mail->setFrom('test@cognitalsolutions.com', 'no-reply');
        $mail->addReplyTo('test@cognitalsolutions.com', 'no-reply');

        // Add a recipient 
        $mail->addAddress($toEmail);

        //$mail->addCC('cc@example.com'); 
        //$mail->addBCC('bcc@example.com'); 

        // Set email format to HTML 
        $mail->isHTML(true);

        // Mail subject 
        $mail->Subject = 'Reminder';

        // Mail body content 
        $mail->Body    = $mailContent;

        // Send email 
        if (!$mail->send()) {
            echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
            return 0;
        } else {
            echo 'Message has been sent.';
            return 1;
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}

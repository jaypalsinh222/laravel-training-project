<?php

namespace App\Imports;

use App\Jobs\MailVerification;
use App\Jobs\SendMailToUsers;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
//        foreach ($rows as $row) {
//            $mailData[] = [
//                'email' => $row['email'],
//                'name' => $row['name'],
//                'phone' => $row['phone'],
//            ];
//        }
//        dd($mailData[3]);
        $emails = $rows->pluck('email');
//        dd($emails->all(), $emails);
        dispatch(new SendMailToUsers($rows->all()));
    }
}

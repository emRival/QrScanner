<?php

namespace App\Http\Controllers;

use App\Models\data;
use App\Models\input;
use Illuminate\Http\Request;

class QrCodeScanner extends Controller
{
    public function validasi (Request $request) {
        $qr = $request->qr_code;
        $data = data::where('qr_code', $qr)->first();
         if ($data == null) {
             return response()->json(['status' => 400, 'message' => 'QR code invalid']);
        }

        $input = input::where('data_id', $data->id)->first();
        
            if ($input != null) {
                // get last input
                $last_input = input::where('data_id', $data->id)->orderBy('created_at', 'desc')->first();
                   $last_update = input::where('data_id', $data->id)->orderBy('updated_at', 'desc')->first();
                if ($last_input->status == 'dipinjam') {
                    $last_input->update([
                        'status' => 'dikembalikan',
                        'dikebalikan_jam' => now()
                    ]);
                    //  dd($last_input);
                   // return date
                   
                    return response()->json(['status' => 200, 'message' => "data {$data->nama} meminjam laptop
                    pada jam {$last_input->diambil_jam} dan mengembalikan
                    pada jam {$last_input->dikebalikan_jam} berhasil  dikembalikan "]);
                   
                     // delete cache browser
                    $this->deleteCache();
                    // find last data
                    // return last data
                } elseif ($input->status == 'dikembalikan') {
            // create new table
                                input::create([
             'data_id' => $data->id,
              'status' => 'dipinjam',
               'diambil_jam' => now(),
         ]);
                    return response()->json(['status' => 200, 'message' => "data {$data->nama} berhasil diinput"]);
                     $this->deleteCache();
                       $this->deleteCacheServer();
                }
                
            } else {
                        input::create([
             'data_id' => $data->id,
              'status' => 'dipinjam',
               'diambil_jam' => now(),
         ]);
          return response()->json(['status' => 200, 'message' => "data diinput pertama"]);
           $this->deleteCache();
            }

        //     input::create([
        //         'data_id' => $data->id,
        //         'status' => 'dipinjam',
        //         'created_at' => now(),
        //     ]);
            
        //     return response()->json(['status' => 200, 'message' => "Selamat Datang {$data->nama} "]);
        // } 
       

        

    } 
}
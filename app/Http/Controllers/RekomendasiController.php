<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laptop;

class RekomendasiController extends Controller
{
    public function store(Request $request)
    {
        $chat_arr = explode(" ", $request->chat);
        if(count($chat_arr) > 3) {
            $rek = config('chat_commands.rekomendasi');
            $cnt = 0;
            foreach($rek as $r) {
                $chat_arr_rek = explode(" ", $r);
                $same = true;
                for($i=0; $i<4; $i++) {
                    if(strtolower($chat_arr[$i]) != strtolower($chat_arr_rek[$i])) {
                        $same = false;
                        break;
                    }
                }
                if($same) {
                    $data = null;
                    if($cnt != 0) {
                        $chat_arr = explode(" ", $request->chat, 5);
                    }
                    if($cnt == 0) {
                        $data = $this->getLaptopHarga(intval($chat_arr[4]), intval($chat_arr[7]));
                    } else if($cnt == 1) {
                        $data = $this->getLaptopMerek($chat_arr[4]);
                    } else if($cnt == 2) {
                        $data = $this->getLaptopNama($chat_arr[4]);
                    } else if($cnt == 3) {
                        $data = $this->getLaptopProsesor($chat_arr[4]);
                    } else if($cnt == 4) {
                        $data = $this->getLaptopRincian($chat_arr[4]);
                    } else if($cnt == 5) {
                        $data = $this->getLaptopUkuran(doubleval($chat_arr[4]));
                    } 
                    return response()->json([
                        'sesi' => 1,
                        'reply' => [
                            'Berikut ini merupakan daftar rekomendasi laptop bedasarkan '.$chat_arr[3].' yang sudah ditentukan',
                            '#data',
                            trim(config('chat_commands.replies')[0]),
                        ],
                        'data' => $data
                    ]);
                }
                $cnt++;
            }
        }
        if($request->sesi == 1) {
            $chat_lower = strtolower($request->chat);
            $percent_same = 0;
            $menu_angka = config('chat_commands.menu_angka')[0];
            $menu = config('chat_commands.menu')[0];
            similar_text($chat_lower, strtolower($menu[0]), $percent_same);
            if($percent_same > 80 || $chat_lower == $menu_angka[0]) {
                return response()->json([
                    'sesi' => 2,
                    'reply' => [
                        trim(config('chat_commands.replies')[1]),
                    ],
                ]);
            }
            similar_text($chat_lower, strtolower($menu[1]), $percent_same);
            if($percent_same > 80 || $chat_lower == $menu_angka[1]) {
                return response()->json([
                    'sesi' => 1,
                    'reply' => [
                        config('chat_commands.merk_list'),
                        '#data',
                        trim(config('chat_commands.replies')[0]),
                    ],
                    'data' => $this->getMerek()
                ]);
            }
            similar_text($chat_lower, strtolower($menu[2]), $percent_same);
            if($percent_same > 80 || $chat_lower == $menu_angka[2]) {
                return response()->json([
                    'sesi' => 1,
                    'reply' => [
                        trim(config('chat_commands.replies')[2]),
                        trim(config('chat_commands.replies')[0]),
                    ],
                ]);
            }
            similar_text($chat_lower, strtolower($menu[3]), $percent_same);
            if($percent_same > 80 || $chat_lower == $menu_angka[3]) {
                return response()->json([
                    'sesi' => 1,
                    'reply' => [
                        trim(config('chat_commands.replies')[3]),
                        trim(config('chat_commands.replies')[0]),
                    ],
                ]);
            }
        } else if($request->sesi == 2) {
            $chat_lower = strtolower($request->chat);
            $percent_same = 0;
            $menu_angka = config('chat_commands.menu_angka')[1];
            $menu = config('chat_commands.menu')[1];
            for($i=0; $i<6; $i++) {
                similar_text($chat_lower, strtolower($menu[$i]), $percent_same);
                if($percent_same > 80 || $chat_lower == $menu_angka[$i]) {
                    return response()->json([
                        'sesi' => 3,
                        'reply' => config('chat_commands.replies')[4][$i],
                        'jenis' => $i,
                    ]);
                }
            }
        }
        $reparray = [
            config('chat_commands.error'),
        ];
        if(intval($request->sesi) < 3)
            array_push($reparray, trim(config('chat_commands.replies')[$request->sesi-1]));
        return response()->json([
            'sesi' => $request->sesi,
            'reply' => $reparray,
        ]);;
    }

    private function getMerek()
    {
        return Laptop::query()->distinct()->pluck('merk');
    }

    private function getLaptopHarga($min, $max)
    {
        return Laptop::where('harga', '>=', $min)->where('harga', '<=', $max)->get();
    }

    private function getLaptopMerek($merek)
    {
        return Laptop::where('merk', 'like', '%'.$merek.'%')->get();
    }

    private function getLaptopNama($nama)
    {
        return Laptop::where('nama', 'like', '%'.$nama.'%')->get();
    }

    private function getLaptopProsesor($prosesor)
    {
        return Laptop::where('cpu', 'like', '%'.$prosesor.'%')->get();
    }

    private function getLaptopRincian($rincian)
    {
        return Laptop::where('rincian', 'like', '%'.$rincian.'%')->get();
    }

    private function getLaptopUkuran($ukuran)
    {
        return Laptop::where('ukuran', '>=', $ukuran-0.7)->where('ukuran', '<=', $ukuran+0.7)->get();
    }
}

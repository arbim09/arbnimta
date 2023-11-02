<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Events;
use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Models\PendaftaranEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        return view('absensi', compact('user'));
    }

    public function camera()
    {
        $user = Auth::user();
        $events = Events::all();
        return view('absensi', compact('user', 'events'));
    }


    public function storeScanData(Request $request)
    {
        $user               = Auth::user();
        $email              = $user->email;
        $eventId            = $request->input('event_id');


        $existingAbsensi    = Absensi::where('user_id', $user->id)
            ->where('event_id', $eventId)
            ->exists();

        if ($existingAbsensi) {
            return response()->json(['success' => false, 'message' => 'Anda telah melakukan absensi pada event ini sebelumnya.']);
        }

        $eventRegistration = PendaftaranEvents::where('user_id', $user->id)
            ->where('event_id', $eventId)
            ->first();

        if ($eventRegistration) {
            $scanData       = [
                'name'      => $user->name,
                'user_id'   => $user->id,
                'event_id'  => $eventId,
                'email'     => $email,
            ];

            Absensi::create($scanData);
            $user           = User::find($user->id);
            $badge          = '';
            if ($user->point >= 10000) {
                $badge = 'Gold Badge';
            } elseif ($user->point >= 5000) {
                $badge = 'Silver Badge';
            } elseif ($user->point >= 1000) {
                $badge = 'Bronze Badge';
            }
            $user->update([
                'point' => $user->point + 100,
                'badge' => $badge
            ]);
            return response()->json(['success' => true, 'message' => 'Data scan berhasil disimpan.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Anda belum terdaftar untuk event ini.']);
        }
    }

    // public function storeScanData(Request $request)
    // {
    //     $user       = Auth::user();
    //     $email      = $user->email;
    //     $eventId    = $request->input('event_id');

    //     $event = Events::find($eventId);

    //     if (!$event) {
    //         return response()->json(['success' => false, 'message' => 'Event tidak ditemukan.']);
    //     }

    //     if ($event->status === 0) {
    //         return response()->json(['success' => false, 'message' => 'Event sudah selesai. QR code tidak berlaku lagi.']);
    //     } else {
    //         $existingAbsensi = Absensi::where('user_id', $user->id)
    //             ->where('event_id', $eventId)
    //             ->exists();

    //         if ($existingAbsensi) {
    //             return response()->json(['success' => false, 'message' => 'Anda telah melakukan absensi pada event ini sebelumnya.']);
    //         }

    //         $scanData = [
    //             'name'      => $user->name,
    //             'user_id'   => $user->id,
    //             'event_id'  => $eventId,
    //             'email'     => $email,
    //         ];

    //         Absensi::create($scanData);

    //         $user = User::find($user->id);
    //         $badge = '';

    //         if ($user->point >= 10000) {
    //             $badge = 'Gold Badge';
    //         } elseif ($user->point >= 5000) {
    //             $badge = 'Silver Badge';
    //         } elseif ($user->point >= 1000) {
    //             $badge = 'Bronze Badge';
    //         }

    //         $user->update([
    //             'point' => $user->point + 100,
    //             'badge' => $badge
    //         ]);

    //         return response()->json(['success' => true, 'message' => 'Data scan berhasil disimpan.']);
    //     }
    // }


    // public function storeScanData(Request $request)
    // {
    //     $user               = Auth::user();
    //     $email              = $user->email;
    //     $eventId            = $request->input('event_id');

    //     $existingAbsensi    = Absensi::where('user_id', $user->id)
    //         ->where('event_id', $eventId)
    //         ->exists();

    //     if ($existingAbsensi) {
    //         return response()->json(['success' => false, 'message' => 'Anda telah melakukan absensi pada event ini sebelumnya.']);
    //     }

    //     $scanData       = [
    //         'name'      => $user->name,
    //         'user_id'   => $user->id,
    //         'event_id'  => $eventId,
    //         'email'     => $email,
    //     ];

    //     Absensi::create($scanData);
    //     $user           = User::find($user->id);
    //     $badge          = '';
    //     if ($user->point >= 10000) {
    //         $badge = 'Gold Badge';
    //     } elseif ($user->point >= 5000) {
    //         $badge = 'Silver Badge';
    //     } elseif ($user->point >= 1000) {
    //         $badge = 'Bronze Badge';
    //     }
    //     $user->update([
    //         'point' => $user->point + 100,
    //         'badge' => $badge
    //     ]);
    //     return response()->json(['success' => true, 'message' => 'Data scan berhasil disimpan.']);
    // }

    // public function storeScanData(Request $request)
    // {
    //     try {
    //         $user = Auth::user();
    //         $email = $user->email;
    //         $eventId = $request->input('event_id');

    //         $existingAbsensi = Absensi::where('user_id', $user->id)
    //             ->where('event_id', $eventId)
    //             ->exists();

    //         if ($existingAbsensi) {
    //             return response()->json(['success' => false, 'message' => 'Anda telah melakukan absensi pada event ini sebelumnya.']);
    //         }

    //         $scanData = [
    //             'name' => $user->name,
    //             'user_id' => $user->id,
    //             'event_id' => $eventId,
    //             'email' => $email,
    //         ];

    //         Absensi::create($scanData);
    //         $user = User::find($user->id);
    //         $badge = '';
    //         if ($user->point >= 10000) {
    //             $badge = 'Gold Badge';
    //         } elseif ($user->point >= 5000) {
    //             $badge = 'Silver Badge';
    //         } elseif ($user->point >= 1000) {
    //             $badge = 'Bronze Badge';
    //         }
    //         $user->update([
    //             'point' => $user->point + 100,
    //             'badge' => $badge
    //         ]);

    //         return response()->json(['success' => true, 'message' => 'Data scan berhasil disimpan.']);
    //     } catch (\Exception $e) {
    //         Log::error('Error in storeScanData: ' . $e->getMessage());
    //         return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat melakukan absensi, silakan coba lagi']);
    //     }
    // }


    // public function storeScanData(Request $request)
    // {
    //     try {
    //         $user = Auth::user();
    //         $email = $user->email;
    //         $eventId = $request->input('event_id');

    //         $existingAbsensi = Absensi::where('user_id', $user->id)
    //             ->where('event_id', $eventId)
    //             ->exists();

    //         if ($existingAbsensi) {
    //             return response()->json(['success' => false, 'message' => 'Anda telah melakukan absensi pada event ini sebelumnya.']);
    //         }

    //         $eventRegistration = PendaftaranEvents::where('user_id', $user->id)
    //             ->where('event_id', $eventId)
    //             ->first();

    //         // dd($eventRegistration);
    //         if ($eventRegistration) {
    //             $scanData = [
    //                 'name' => $user->name,
    //                 'user_id' => $user->id,
    //                 'event_id' => $eventId,
    //                 'email' => $email,
    //             ];

    //             Absensi::create($scanData);
    //             $user = User::find($user->id);
    //             $badge = '';

    //             if ($user->point >= 10000) {
    //                 $badge = 'Gold Badge';
    //             } elseif ($user->point >= 5000) {
    //                 $badge = 'Silver Badge';
    //             } elseif ($user->point >= 1000) {
    //                 $badge = 'Bronze Badge';
    //             }

    //             $user->update([
    //                 'point' => $user->point + 100,
    //                 'badge' => $badge
    //             ]);

    //             return response()->json(['success' => true, 'message' => 'Data scan berhasil disimpan.']);
    //         } else {
    //             Log::error('Event registration not found for user ' . $user->id . ' and event ' . $eventId);
    //             return response()->json(['success' => false, 'message' => 'Anda belum terdaftar untuk event ini.']);
    //         }
    //     } catch (\Exception $e) {
    //         Log::error('Error in storeScanData: ' . $e->getMessage());
    //         return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat melakukan absensi, silakan coba lagi']);
    //     }
    // }
}

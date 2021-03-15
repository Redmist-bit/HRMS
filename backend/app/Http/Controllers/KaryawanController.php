<?php

namespace App\Http\Controllers;
use File;
use Image;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Karyawan::take(100)->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $krywn = new Karyawan;
        $last = DB::table('karyawan')->orderBy('KODE_KARYAWAN', 'desc')->first();
        if (isset($last) == null) {
            $fixcode = '01/000001';
        } else {
            $kode = substr($last->KODE_KARYAWAN,3);
            $kode_dpn = substr($last->KODE_KARYAWAN,0,3);
            $fixcode = $kode_dpn.str_pad($kode+1, 6, "0", STR_PAD_LEFT);
        };
        $krywn->KODE_KARYAWAN = $fixcode;
        $krywn->NAMA = $request->Nama;
        $krywn->NRK = $request->Nrk;
        $krywn->KODE_JABATAN = $request->Kode_Jabatan;
        $krywn->POH = $request->Poh;
        $krywn->TGL_MASUK = $request->Tgl_Masuk;
        $krywn->TEMPAT_LAHIR = $request->Tempat_Lahir;
        $krywn->TGL_LAHIR = $request->Tgl_Lahir;
        $krywn->ALAMAT_KTP = $request->Alamat_Ktp;
        $krywn->ALAMAT_SEKARANG = $request->Alamat_Sekarang;
        $krywn->NO_TLP = $request->No_Tlp;
        $krywn->JENIS_KELAMIN = $request->Jenis_Kelamin;
        $krywn->PENDIDIKAN_TERAKHIR = $request->Pendidikan_Terakhir;
        $krywn->JURUSAN = $request->Jurusan;
        $krywn->AGAMA = $request->Agama;
        $krywn->SUKU = $request->Suku;
        $krywn->NO_REK_TABUNGAN = $request->No_Rek_Tabungan;
        $krywn->NO_KARTU_BPJS_TK = $request->No_Kartu_Bpjs_Tk;
        $krywn->NO_KARTU_BPJS_KES = $request->No_Kartu_Bpjs_Kes;
        $krywn->NO_KTP = $request->No_Ktp;
        $krywn->NO_NPWP = $request->No_Npwp;
        $krywn->GOL_DR = $request->Gol_Dr;
        $krywn->STATUS = $request->Status;
        $krywn->STATUS_KERJA = $request->Status_Kerja;
        $krywn->UKURAN_BAJU = $request->Ukuran_Baju;
        $krywn->UKURAN_SEPATU = $request->Ukuran_Sepatu;
        $krywn->PHK = $request->Phk;
        $krywn->TGL_PHK = $request->Tgl_Phk;
        $krywn->KETERANGAN = $request->Keterangan;
        if ($request->hasFile('files')) {
            $files= $request->file('files');
            $date = date('YmdHis');
            $filename = '/Photo/Karyawan/'.$date. $files->getClientOriginalName();
            $img = Image::make($files);
            $img->save(public_path($filename,100));
            $krywn->PHOTO = $filename;
        }else{
            $krywn->PHOTO = '/Photo/no.png';
        }
        // dd($krywn->PHOTO);
        $krywn->NAMA_ISTRI_SUAMI = $request->Nama_Istri_Suami;
        $krywn->DiBuatOleh = $request->DiBuatOleh;
        // $krywn->DiBuatTgl = $request->DiBuatTgl;
        $krywn->DiubahOleh = $request->DiubahOleh;
        // $krywn->DiubahTgl = $request->DiubahTgl;

        if ($krywn->save()){
            return response()->json([
                "status" => 'success',
                "Karyawan" => $krywn
            ]);
        }
        else {
            return response()->json([
                "status" => 'fail',
                "message" => "gagal save"
            ], 500);
        };
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Karyawan  $karyawan
     * @return \Illuminate\Http\Response
     */
    public function show($id,$kode)
    {
        $x = $id;
        $x.= '/' ;
        $x.= $kode;
        $data = Karyawan::find($x);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Karyawan  $karyawan
     * @return \Illuminate\Http\Response
     */
    public function edit(Karyawan $karyawan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Karyawan  $karyawan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Karyawan $karyawan, $id,$kode)
    {
        $x = $id ;
        $x.= '/' ;
        $x.= $kode;
        $data = Karyawan::where('KODE_KARYAWAN',$x)->update([
            "NAMA"=>$request->Nama,
            "NRK"=>$request->Nrk,
            "KODE_JABATAN"=>$request->Kode_Jabatan,
            "POH"=>$request->Poh,
            "TGL_MASUK"=>$request->Tgl_Masuk,
            "TEMPAT_LAHIR"=>$request->Tempat_Lahir,
            "TGL_LAHIR"=>$request->Tgl_Lahir,
            "ALAMAT_KTP"=>$request->Alamat_Ktp,
            "ALAMAT_SEKARANG"=>$request->Alamat_Sekarang,
            "NO_TLP"=>$request->No_Tlp,
            "JENIS_KELAMIN"=>$request->Jenis_Kelamin,
            "PENDIDIKAN_TERAKHIR"=>$request->Pendidikan_Terakhir,
            "JURUSAN"=>$request->Jurusan,
            "AGAMA"=>$request->Agama,
            "SUKU"=>$request->Suku,
            "NO_REK_TABUNGAN"=>$request->No_Rek_Tabungan,
            "NO_KARTU_BPJS_TK"=>$request->No_Kartu_Bpjs_Tk,
            "NO_KARTU_BPJS_KES"=>$request->No_Kartu_Bpjs_Kes,
            "NO_KTP"=>$request->No_Ktp,
            "NO_NPWP"=>$request->No_Npwp,
            "GOL_DR"=>$request->Gol_Dr,
            "STATUS"=>$request->Status,
            "STATUS_KERJA"=>$request->Status_Kerja,
            "UKURAN_BAJU"=>$request->Ukuran_Baju,
            "UKURAN_SEPATU"=>$request->Ukuran_Sepatu,
            "PHK"=>$request->Phk,
            "TGL_PHK"=>$request->Tgl_Phk,
            "KETERANGAN"=>$request->Keterangan,
            "NAMA_ISTRI_SUAMI"=>$request->Nama_Istri_Suami,
            "DiubahOleh"=>$request->DiubahOleh,
        ]);
        if ($data == 1) {
            return response()->json([
                "status"=>'success',
            ],200);
        }else if($data == 0){
            return response()->json([
                "status"=>'tidak ada yg di update',
            ],200);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Karyawan  $karyawan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Karyawan $karyawan,$id,$kode)
    {
        $x = $id;
        $x.= '/';
        $x.= $kode;
        $foto = Karyawan::where('KODE_KARYAWAN',$x)->get();
        foreach ($foto as $key => $value) {
            $path = substr($value->PHOTO,1);
        }
            if(File::exists($path)) {
                if($path == "Photo/no.png"){
                    //do nothing
                }else{
                 File::delete($path); 
                }
               
            } else {
                return response()->json('delete image not success in path');
            }
        $del = DB::delete('delete from karyawan where KODE_KARYAWAN = :kd',['kd'=>$x]);
        if ($del == 1) {
            return response()->json([
                "status"=>'success',
            ],200);
        }
    }
    public function uploadFotoKaryawan(Request $req, $id,$kode)
    {   
        $x = $id ;
        $x.= '/' ;
        $x.= $kode;
        $foto = Karyawan::where('KODE_KARYAWAN',$x)->get();
        foreach ($foto as $key => $value) {
            $path = substr($value->PHOTO,1);
        }
            if(File::exists($path)) {
                if($path == "Photo/no.png"){
                    //do nothing
                }else{
                 File::delete($path); 
                }
               
            } else {
                return response()->json('delete image not success in path');
            }
        if ($req->hasFile('files')) {
            $files= $req->file('files');
            $date = date('YmdHis');
            $filename = '/Photo/Karyawan/'.$date. $files->getClientOriginalName();
            $img = Image::make($files);
            $img->save(public_path($filename,100));
                
            Karyawan::where('KODE_KARYAWAN',$x)->update([
                    'PHOTO' => $filename,
                ]);
            }   
            return response()->json(['status' => 'success','foto' => $filename]);
        }

}

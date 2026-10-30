public function index($idbarang)
{
    $kartuStok = DB::table('kartu_stok')
        ->where('idbarang', $idbarang)
        ->orderBy('idkartu_stok', 'desc')
        ->get();

    return view('kartu_stok.index', compact('kartuStok'));
}
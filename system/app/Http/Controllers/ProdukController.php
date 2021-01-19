<?php 

namespace App\Http\Controllers;
use App\Models\Produk;
use App\Models\Provinsi;


class ProdukController extends Controller {

	function homeIndex(){
	$data['list_produk'] = Produk::Paginate(5);
	$data['list_provinsi'] = provinsi::all();

	return view ('home', $data);

	}
	function index(){
		$user = request()->user();
		$produk['list_produk'] = $user->produk;
		


		return view ('produk.index', $produk);

	}

	function create(){
		return view ('produk.create');

	}

	function store(){

	
		$produk = new Produk;
		$produk->id_user = request()->user()->id;
		$produk->nama = request('nama');
		$produk->harga = request('harga');
		$produk->berat = request('berat');
		$produk->stok = request('stok');
		$produk->deskripsi = request('deskripsi');
		$produk->save();

		$produk->handleUploadFoto();

		return redirect('produk')->with('success', 'Data Berhasil Ditambahkan');

	}


	function show(Produk $produk){
		$data['produk'] = $produk;
		return view('produk.show', $data);
	}

	function edit(Produk $produk){
		$data['produk'] = $produk;

		return view('produk.edit', $data);
		
	}

	function update(Produk $produk){
		$produk->nama = request('nama');
		$produk->harga = request('harga');
		$produk->berat = request('berat');
		$produk->stok = request('stok');
		$produk->deskripsi = request('deskripsi');
		$produk->save();

		$produk->handleUploadFoto();

		return redirect('produk')->with('warning', 'Data Berhasil Diedit');
		
	}

	function destroy(Produk $produk){

		$produk->handleDelete();
		$produk->delete();

		return redirect ('produk')->with('danger', 'Data Berhasil Dihapus');
	}

	function filter (){
		$nama = request('nama');
		$stok = explode(", ", request('stok'));
		$data['harga_min'] = $harga_min = request ('harga_min');
		$data['harga_max'] = $harga_max = request ('harga_max');
		//select * from produk where nama = $nama
		//$data['list_produk'] = Produk::where('nama', 'like', "%$nama%")->get();
		//$data['list_produk'] = Produk::whereIn('stok', $stok)->get();
		//$data['list_produk'] = Produk::whereBetween('harga', [$harga_min, $harga_max])->get();

		//$data['list_produk'] = Produk::where('stok', '<>', $stok)->get();
		//$data['list_produk'] = Produk::whereNotIn('stok', $stok)->get();
		//$data['list_produk'] = Produk::whereNotBetween('harga', [$harga_min, $harga_max])->get();

		//$data['list_produk'] = Produk::whereNull('stok')->get();
		//$data['list_produk'] = Produk::whereNotNull('stok')->get();

		//$data['list_produk'] = Produk::whereDate('created_at', '2020-11-22')->get();
		//$data['list_produk'] = Produk::whereYear('created_at', '2020')->get();
		//$data['list_produk'] = Produk::whereMonth('created_at', '11')->get();
		//$data['list_produk'] = Produk::whereTime('created_at', '03:37:34')->get();
		//$data['list_produk'] = Produk::whereDate('created_at', ['2020-11-14', '2020-11-22'])->get();

        $data['list_produk'] = Produk::whereBetween('harga', [$harga_min, $harga_max])->whereNotIn('stok', [50])->whereYear('created_at', '2020')->get();



		$data['nama'] = $nama;
		$data['stok'] = request ('stok');


		return view('produk.index', $data);
	}


 }
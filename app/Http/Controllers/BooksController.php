<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// 使うClassを宣言
use App\Book;
use Validator;
use Auth;

class BooksController extends Controller
{

    public function __construct() {
        $this -> middleware('auth');
    }

    // 本ダッシュボード表示
    public function index()
    {
        $books = Book::where('user_id', Auth::user() -> id)
            -> orderBy('created_at', 'asc') 
            -> paginate(3);
        return view('books', [
            'books' => $books
        ]);
    }

    // 登録
    public function store(Request $request)
    {
        $validator = Validator::make($request-> all(), [
            'item_name' => 'required|max:255',
            'item_number' => 'required|max:3|min:1',
            'item_amount' => 'required|max:6',
            'published' => 'required'
        ]);
        if ($validator-> fails()) {
            return redirect('/')
                -> withInput()
                -> withErrors($validator);
        }

        $file = $request -> file('item_img'); // fileを取得
        if (!empty($file)) {
            $filename = $file -> getClientOriginalName(); // ファウル名を取得
            $move = $file -> move('assets/upload/' , $filename);  // ファイルを移動
        } else {
            $filename = '';
        }
    
        $books = new Book;
        $books -> user_id = Auth::user() -> id;
        $books -> item_name = $request -> item_name;
        $books -> item_number = $request -> item_number;
        $books -> item_amount = $request -> item_amount;
        $books -> item_img = $filename;
        $books -> published = $request -> published;
        $books -> save();
        return redirect('/') -> with('message', '本登録が完了しました。');
    }

    // 更新画面
    public function edit($book_id)
    {
        $books = Book::where('user_id', Auth::user() -> id) -> find($book_id);
        return view('booksedit', ['book' => $books]);
    }
    // public function edit(Book $books)
    // {
    //     return view('booksedit', ['book' => $books]);
    // }

    // 更新処理
    public function update(Request $request)
    {
        // バリデーション
        $validator = Validator::make($request-> all(), [
            'id' => 'required',
            'item_name' => 'required|max:255',
            'item_number' => 'required|max:3|min:1',
            'item_amount' => 'required|max:6',
            'published' => 'required'
            ]);
    
        // バリデーションエラー
        if ($validator -> fails()) {
            return redirect('/')
                -> withInput()
                -> withErrors($validator);
        }
    
        // データ更新
        // $books = Book::find($request -> id);
        $books = Book::where('user_id', Auth::user()->id) -> find($request -> id);
        $books -> item_name = $request -> item_name;
        $books -> item_number = $request -> item_number;
        $books -> item_amount = $request -> item_amount;
        $books -> published = $request -> published;
        $books -> save();
        return redirect('/');
    }
    
    // 削除処理
    public function destroy(Book $book)
    {
        $book-> delete();
        return redirect('/');
    }
}

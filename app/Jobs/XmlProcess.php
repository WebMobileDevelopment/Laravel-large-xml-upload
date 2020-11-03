<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class XmlProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $books;
    public function __construct($books)
    {
        $this->books = $books;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // var_dump($this->books);

        foreach ($this->books as $book) {
            $data = [
                'Image' => $book['image'],
                'Description' => $book['description'],
                'ISBN' => $book['isbn'],
                'Title' =>  $book['title']
            ];
            $book_row = DB::table('books')->where('ISBN', '=', $data['ISBN'])->first();
            if ($book_row === null) {
                DB::table('books')->insert($data);
            }
        }
    }
    private function Parse($url_string)
    {

        $fileContents = file_get_contents($url_string);

        $fileContents = str_replace(array("\n", "\r", "\t"), '', $fileContents);

        $fileContents = trim(str_replace('"', "'", $fileContents));

        $simpleXml = simplexml_load_string($fileContents);
        $simpleXml = json_encode($simpleXml);
        $simpleXml = str_replace("@", "", $simpleXml);
        $array = json_decode($simpleXml);
        return $array;
    }
}

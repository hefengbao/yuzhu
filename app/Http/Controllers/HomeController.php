<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\One\RssFeed;
use App\Repositories\PostRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

class HomeController extends Controller
{
    protected $postRepository;
    protected $rssFeed;

    public function __construct(PostRepository $postRepository,RssFeed $rssFeed)
    {
       // $this->middleware('auth');
        $this->postRepository  = $postRepository;
        $this->rssFeed = $rssFeed;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->postRepository->paginate();
        return view('home',compact('posts'));
    }

    public function feed()
    {
        $rss = $this->rssFeed->getFeed();
        return response($rss)->header('Content-Type','text/xml');
    }

    public function sitemap(){
        $sitemap = App::make("sitemap");
        // set cache key (string), duration in minutes (Carbon|Datetime|int), turn on/off (boolean)
        // by default cache is disabled
        $sitemap->setCache('laravel.sitemap', 60);

        // check if there is cached sitemap and build new only if is not
        if (!$sitemap->isCached()) {

            // add item to the sitemap (url, date, priority, freq)
            $sitemap->add(URL::to('/'), 'Carbon::now()->timestamp', '1.0', 'daily');
            $sitemap->add(URL::to('archives'), Carbon::now()->timestamp, '1.0', 'daily');
            $sitemap->add(URL::to('tags'), Carbon::now()->timestamp, '1.0', 'daily');

            $posts = Post::select('updated_at','post_slug')
                ->published()
                ->orderBy('created_at', 'desc')
                ->get();

            // add every post to the sitemap
            foreach ($posts as $post)
            {
                $sitemap->add('article/'.$post->post_slug,$post->updated_at);
            }
        }
        // show your sitemap (options: 'xml' (default), 'html', 'txt', 'ror-rss', 'ror-rdf')
        return $sitemap->render('xml');
    }
}

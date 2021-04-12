@props(['post' => $post])
<div class="mb-4">
    <a href="{{route('users.post', $post->user)}}" class="font-bold">{{$post->user->name}}</a> <span class="text-gray-600 text-sm">{{$post->created_at->diffForHumans()}}</span>

    <p class="mb-2">{{$post->body}}</p>

    @can('delete',$post)
        <form action="{{route('posts.delete',$post)}}" method="post" class="mr-1">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-blue-500">Delete</button>
        </form>
    @endcan
    <div class="flex items-center">
        @auth
            @if(!$post->likedBy(auth()->user()))
                <form action="{{route('post.like',$post)}}" method="post" class="mr-1">
                    @csrf
                    <button type="submit" class="text-blue-500">Like</button>
                </form>
            @else
                <form action="{{route('post.like',$post)}}" method="post" class="mr-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-blue-500">Unlike</button>
                </form>
            @endif
        @endauth

        {{$post->likes->count()}} {{Str::plural('like', $post->likes->count())}}
    </div>
</div>

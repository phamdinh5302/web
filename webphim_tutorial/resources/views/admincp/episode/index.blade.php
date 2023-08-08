@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                
                <table class="table" >
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tên phim</th>
                            <th scope="col">Hình ảnh </th>
                            <th scope="col">Tập phim</th>
                            <th scope="col">Link phim</th>
                            {{-- <th scope="col">Trạng thái</th> --}}
                            <th scope="col">Manage</th>
                        </tr>
                    </thead>
                    <tbody class="order_position">
                        @foreach ($list_episode as $key => $episode)
                        
                            <tr >
                                <th scope="row">{{ $key }}</th>
                                <td>{{ $episode->movie->title }}</td>
                                <td><img width="100px" src="{{ asset('uploads/movie/' . $episode->movie->image) }}"></td>
                                <td>{{ $episode->episode }}</td>
                                <td>
                                    {{$episode->linkphim}}
                                    {{-- <iframe width="500px" height="300px" src="{{$episode->linkphim}} "
                                        title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen>
                                    </iframe> --}}
                                </td>
                                {{-- <td>
                                    @if ($episode->status)
                                        Hiển thị
                                    @else
                                        Không hiển thị
                                    @endif
                                </td> --}}
                                <td>
                                    {!! Form::open([
                                        'method' => 'DELETE',
                                        'route' => ['episode.destroy', $episode->id],
                                        'onsubmit' => 'return confirm("Xóa hay không?")',
                                    ]) !!}
                                    {!! Form::submit('Xóa', ['class' => 'btn btn-danger']) !!}
                                    {!! Form::close() !!}
                                    <a href="{{ route('episode.edit', $episode->id) }}" class="btn btn-warning">Sửa</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

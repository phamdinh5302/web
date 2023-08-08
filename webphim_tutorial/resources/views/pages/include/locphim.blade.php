<form action="{{route('locphim')}}" method="GET">
    <div class="col-md-3">
        <div class="form-group">
            <select class="form-control" name="oder" id="exampleFormControlSelect1">
                <option value="">--- Sắp xếp ---</option>
                <option value="date">Ngày đăng</option>
                <option value="year_realease">Năm sản xuất</option>
                <option value="name">Tên phim</option>
                <option value="watch_views">Lượt xem</option>    
            </select>
        </div>
    </div>   
    <div class="col-md-3">
        <div class="form-group">
            <select class="form-control" name="genre" id="exampleFormControlSelect1" >
                <option value="">--- Thể loại ---</option>
                @foreach ($genre as $key => $gen_filter)
                    <option value="{{ $gen_filter->id }}">{{ $gen_filter->title }}</option>
                @endforeach
            </select>
        </div>
    </div>   
    <div class="col-md-3">
        <div class="form-group">
            <select class="form-control"  name="country" id="exampleFormControlSelect1">
                <option value="">--- Quốc gia ---</option>
                @foreach ($country as $key => $count_filter)
                    <option value="{{ $count_filter->id }}">{{ $count_filter->title }}</option>
                @endforeach
            </select>
        </div>
    </div>   
    <div class="col-md-3">
        <div class="form-group">
            <select class="form-control" name="year" id="exampleFormControlSelect1">
                <option value="">--- Năm ---</option>
                @for ($year = 1980; $year <= 2023 ; $year++)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endfor
            </select>
        </div>
    </div>   
    <input type="submit" name="locphim" class="btn btn-sm btn-default" value="Lọc phim">                     
</form>
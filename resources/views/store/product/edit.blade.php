@extends('layouts.app')

@if ( isset($product) )
    @section('title', 'Редактирование №' . $product->id)
@else
    @section('title', 'Добавление товара')
@endif

@section('content')
    <section id="content">
        <div id="breadcrumb-container">
            <div class="container">
                <ul class="breadcrumb">
                    <li>
                        <a href="{{ route('home') }}">Главная</a>
                    </li>
                    <li class="active">
                      @if ( isset($product) )
                        <a href="{{ route('prod.view', [$product]) }}">{{$product->title}}</a>
                      @else
                        <a href="{{ URL::previous() }}">Вернуться</a>
                      @endif
                    </li>
                </ul>
            </div>
        </div>
        <div class="container">

                <!--Grid row-->
                <div class="row">

                    <!--Grid column-->
                    <div class="col-lg-12">

                        <!--Leave a reply form-->
                        <div class="">
                            @if ( isset($product) )
                                {!! Form::model($product, ['route' => ['prod.save', $product]]) !!}
                            @else
                                {!! Form::open(['route' => ['prod.new']]) !!}
                            @endif
                            
                                @include('components.form.text', [
                                    'name' => 'title', 
                                    'title' => 'Название',
                                ])
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            @include('components.form.text', [
                                                'name' => 'price', 
                                                'title' => 'Цена', 
                                            ])
                                        </div>
                                        <div class="col-xs-4">
                                            @include('components.form.text', [
                                                'name' => 'price_old', 
                                                'title' => 'Старая цена',
                                                'required' => false,
                                            ])
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            @include('components.form.text', [
                                                'name' => 'options[size][length]', 
                                                'title' => 'Длина',
                                                'required' => false,
                                            ])
                                        </div>
                                        <div class="col-xs-3">
                                            @include('components.form.text', [
                                                'name' => 'options[size][height]', 
                                                'title' => 'Высота',
                                                'required' => false,
                                            ])
                                        </div>
                                        <div class="col-xs-3">
                                            @include('components.form.text', [
                                                'name' => 'options[size][width]', 
                                                'title' => 'Ширина',
                                                'required' => false,
                                            ])
                                        </div>
                                    </div>
                                </div>
                                @include('components.form.textarea', [
                                    'name' => 'description', 
                                    'title' => 'Описание',
                                    'method' => 'textarea', 
                                    'attributes' => [
                                        'rows' => 3,
                                        'tinymce',
                                    ],
                                    'required' => false,
                                ])
                                @include('components.form.textarea', [
                                    'name' => 'meta_description', 
                                    'title' => 'Описание (META)',
                                    'method' => 'textarea', 
                                    'attributes' => [
                                        'rows' => '3',
                                    ],
                                    'required' => false,
                                ])
                                @include('components.form.select', [
                                    'name' => 'categories[]',
                                    'title' => 'Категории',
                                    'items' => $categoriesAll->pluck('name', 'id'),
                                    'attributes' => [
                                        'multiple' => 'multiple',
                                        'class' => 'form-control'
                                    ],
                                ])
                                @include('components.form.submit', ['title' => 'Сохранить'])
                            {!! Form::close() !!}
                        </div>
                        <!--/.Leave a reply form-->

                    </div>
                    <!--Grid column-->

                </div>
                <!--Grid row-->

            </div>
    </section>
@endsection

@section('js')
<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=8tdlfa0wenwav42mprv1nlsgo33l5nufbbb2cwkwo2qazwpy"></script>

<script>
    tinymce.init({
    selector: 'textarea[tinymce]',
    height: 400,
    menubar: false,
    language_url: '{{ elixir("js/tinymce_ru.js") }}',
    plugins: [
        'emoticons codesample advlist autolink lists link image charmap print preview anchor textcolor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table contextmenu paste code help wordcount'
    ],
    // bbcode_dialect: "punbb",
    toolbar: 'emoticons | codesample | insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help | preview | image code',

    // without images_upload_url set, Upload tab won't show up
    // images_upload_url: '/postAcceptor.php',
    images_upload_credentials: true,

    images_upload_handler: function (blobInfo, success, failure) {
    var xhr, formData;
    var webPath = '/test';
    xhr = new XMLHttpRequest();
    xhr.withCredentials = false;
    xhr.open('POST', webPath);
    xhr.onload = function() {
      var json;

      if (xhr.status != 200) {
        failure('HTTP Error: ' + xhr.status);
        return;
      }
      json = JSON.parse(xhr.responseText);

      if (!json || typeof json.location != 'string') {
        failure('Invalid JSON: ' + xhr.responseText);
        return;
      }
      success(json.location);
    };
    formData = new FormData();
    formData.set('_token', $('meta[name="csrf-token"]').attr('content'));
    formData.append('file', blobInfo.blob(), (blobInfo));
    xhr.send(formData);
  },

    content_css: [
        '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
        '//www.tinymce.com/css/codepen.min.css']
    });
</script>
@endsection
@extends('layouts.app')

@section('content')
@include('layouts.menubar')
<link rel="stylesheet" type="text/css" href="{{ asset('/frontend/styles/blog_styles.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('/frontend/styles/blog_responsive.css') }}">

<div class="blog">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="flex-row blog_posts d-flex align-items-start justify-content-between">

					@foreach($post as $row)
						<!-- Blog post -->
						<div class="blog_post">
	                     <div class="blog_image" style="background-image:url({{ asset($row->post_image) }})"></div>
							<div class="blog_text">
								@if(Session()->get('lang') == 'arabic')
								{{ $row->post_title_ar }}
								@else
								{{ $row->post_title_en }}
								@endif

							</div>
							<div class="blog_button"><a href="{{ url('blog/single/'.$row->id) }}">
                            @if(Session()->get('lang') == 'arabic')
								تــأبع ألـقراءة
								@else
								Continue Reading
								@endif

						</a></div>
						</div>
                 @endforeach


					</div>
				</div>

			</div>
		</div>
	</div>

@endsection

@extends("cms::layouts.default")

@section("content")
	<div class="container">
		<form action="{{route('cms:plugins:fileImporters.action')}}"
		      method="POST">
			
			{{csrf_field()}}
			<div class="form-group">
				{{Form::label('path','Path',['class'=>'form-label'])}}
				{{Form::text('path',null,['class'=>$errors->has('path')?"form-control is-invalid":"form-control",'required'])}}
				@if ($errors->has('path'))
					<span class="invalid-feedback">
			          <strong>{{ $errors->first('path') }}</strong>
			      </span>
				@endif
			</div>
			
			<div class="form-group">
				{{Form::label('page_id','Page',['class'=>'form-label'])}}
				{{Form::select('page_id',$pages,null,['class'=>$errors->has('page_id')?"form-control is-invalid":"form-control",'required'])}}
				@if ($errors->has('page_id'))
					<span class="invalid-feedback">
			          <strong>{{ $errors->first('page_id') }}</strong>
			      </span>
				@endif
			</div>
			
			<div class="form-group">
				{{Form::label('identifier','Identifier Prefix',['class'=>'form-label'])}}
				{{Form::text('identifier',null,['class'=>$errors->has('identifier')?"form-control is-invalid":"form-control",'required'])}}
				@if ($errors->has('identifier'))
					<span class="invalid-feedback">
			          <strong>{{ $errors->first('identifier') }}</strong>
			      </span>
				@endif
			</div>
			<div class="form-group">
				{{Form::label('lang_code','Identifier Prefix',['class'=>'form-label'])}}
				{{Form::select('lang_code',array_combine($langCodes,$langCodes),null,['class'=>$errors->has('lang_code')?"form-control is-invalid":"form-control",'required'])}}
				@if ($errors->has('lang_code'))
					<span class="invalid-feedback">
			          <strong>{{ $errors->first('lang_code') }}</strong>
			      </span>
				@endif
			</div>
			
			<div class="form-group">
				{{Form::label('content_type','Content Type',['class'=>'form-label'])}}
				{{Form::select('content_type',$types,null,['class'=>$errors->has('content_type')?"form-control is-invalid":"form-control",'required'])}}
				@if ($errors->has('content_type'))
					<span class="invalid-feedback">
			          <strong>{{ $errors->first('content_type') }}</strong>
			      </span>
				@endif
			</div>
			
			<div class="form-group">
				<button class="btn btn-success">Submit</button>
			</div>
		</form>
	</div>
@endsection

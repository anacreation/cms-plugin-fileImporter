@extends("cms::layouts.default")

@section("content")
	<div class="container">
		<form>
			<div class="form-group">
				{{Form::label('name','Name',['class'=>'form-label'])}}
				{{Form::text('name',null,['class'=>$errors->has('name')?"form-control is-invalid":"form-control"])}}
				@if ($errors->has('name'))
					<span class="invalid-feedback">
			          <strong>{{ $errors->first('name') }}</strong>
			      </span>
				@endif
			</div>
		</form>
	</div>
@endsection

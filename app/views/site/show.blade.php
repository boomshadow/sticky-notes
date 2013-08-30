@extends('common.page')

@section('body')
	@include('common.alerts')

	<section id="show">
		<div class="row">
			<div class="col-sm-12">
				<div class="pre-info pre-header">
					<div class="row">
						<div class="col-sm-5">
							<h4>
								@if (empty($paste->title))
									{{ Lang::get('global.paste') }}

									@if ($paste->urlkey)
										#p{{ $paste->urlkey }}
									@else
										#{{ $paste->id }}
									@endif
								@else
									{{{ $paste->title }}}
								@endif
							</h4>
						</div>

						<div class="col-sm-7 text-right">
							{{
								link_to("#", Lang::get('show.short_url'), array(
									'class' => 'btn btn-success'
								))
							}}

							{{
								link_to("#", Lang::get('show.wrap'), array(
									'class' => 'btn btn-success'
								))
							}}

							{{
								link_to(Paste::getUrlKey($paste)."/{$paste->hash}/raw", Lang::get('show.raw'), array(
									'class' => 'btn btn-success'
								))
							}}

							{{
								link_to('rev/'.Paste::getUrlKey($paste), Lang::get('show.revise'), array(
									'class' => 'btn btn-success'
								))
							}}

							@include('site.actions')
						</div>
					</div>
				</div>

				{{ Highlighter::make()->parse($paste->data, $paste->language) }}

				<div class="pre-info pre-footer">
					<div class="row">
						<div class="col-sm-6">
							{{ sprintf(Lang::get('global.language'), $paste->language) }}
						</div>

						<div class="col-sm-6 text-right">
							{{{ sprintf(Lang::get('global.posted_by'), $paste->author ?: Lang::get('global.anonymous'), date('d M Y, H:i:s e', $paste->timestamp)) }}}
						</div>
					</div>
				</div>

				@if (count($paste->revisions) > 0)
					<fieldset class="well well-small well-white well-history">
						<h4>
							<span class="glyphicon glyphicon-time"></span>
							{{ Lang::get('show.version_history') }}
						</h4>

						<div class="viewport">
							<table class="table table-striped table-responsive">
								<colgroup>
									<col class="col-xs-3" />
									<col class="col-xs-3" />
									<col class="col-xs-5" />
									<col class="col-xs-1" />
								</colgroup>

								<thead>
									<tr>
										<th>{{ Lang::get('show.revision_id') }}</th>
										<th>{{ Lang::get('global.author') }}</th>
										<th>{{ Lang::get('show.created_at') }}</th>
										<th></th>
									</tr>
								</thead>

								<tbody>
									@foreach ($paste->revisions as $revision)
										<tr>
											<td>
												{{
													link_to(Paste::getUrlKey($revision), Paste::getUrlKey($revision))
												}}
											</td>

											<td>
												{{{
													$paste->author ?: Lang::get('global.anonymous')
												}}}
											</td>

											<td>
												{{
													date('d M Y, H:i:s e', $revision->timestamp)
												}}
											</td>

											<td class="text-right">
												{{
													link_to('diff/'.Paste::getUrlKey($paste).'/'.$revision->urlkey, Lang::get('show.diff'), array(
														'class' => 'btn btn-xs btn-default'
													))
												}}
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</fieldset>
				@endif
			</div>
		</div>
	</section>
@stop

@extends('layouts.default')

@section('content')
<div id="widget-grid">
    <div class="row">
        <div class="col-sm-12">
            <div class="jarviswidget">
                <header>
                    <span class="widget-icon"> <i class="glyphicon glyphicon-stats"></i> </span>
                    <h2>YOUR CAMPAIGNS LIST</h2>
                </header>

                <div class="widget-body">
                    <div class="row actions-toolbar">
                        <div class="col-sm-6">
							<div class="input-group">
								<div class="input-group-btn">
									<a href="/admin/campaigns/create">
										<button class="btn btn-default btn-primary" type="button">
											<i class="fa fa-plus-square-o"></i> New Campaign
										</button>
									</a>
								</div>
							</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="icon-addon addon-sm pull-right">
                                <label class="glyphicon glyphicon-search"></label>                        
                                <input id="campaigns-search-1"
                                       name="campaigns-search-1"
                                       class="form-control"
                                       placeholder="Search"
                                       type="text"
                                v-model="search">
                            </div>
                            <div class="btn-group btn-group-sm pull-right">
                               
                            </div>
                        </div>
                    </div>

                    <div id="dt_basic_wrapper" class="dataTables_wrapper form-inline no-footer">
                        <campaigns></campaigns>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

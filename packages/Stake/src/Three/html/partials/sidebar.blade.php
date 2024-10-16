<div class="accordion" id="accordion1">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="searchOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#searchCollapseOne" aria-expanded="true" aria-controls="searchCollapseOne">
                                            Search Filters
                                        </button>
                                    </h2>
                                    <div id="searchCollapseOne" class="accordion-collapse collapse show" aria-labelledby="searchOne" data-bs-parent="#accordion1">
                                        <div class="accordion-body">
                                            <div class="accordion-inner clearfix">
                                                <ul class="list-unstyled" id="list-unstyled">
                                                    
                                                </ul>
                                                <a class="clear-filters" href="/search" rel="nofollow">Clear All</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                            <div class="accordion" id="accordion2">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="searchTwo">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#searchCollapseTwo" aria-expanded="true" aria-controls="searchCollapseTwo">
                                            Search By Keyword
                                        </button>
                                    </h2>
                                    <div id="searchCollapseTwo" class="accordion-collapse collapse show" aria-labelledby="searchTwo" data-bs-parent="#accordion2">
                                        <div class="accordion-body">
                                            <div class="accordion-inner clearfix">
                                                <form id="search_key_form" action="#" method="GET">
                                                    <input class="pr35 form-control" id="search_input" name="q" @if(!empty($q)) value="{{$q}}" @endif placeholder="e.g. Property, Car, Job" type="text" />
                                                    <input class="btn btn-primary refine-go" type="submit" id="searchInput" value="Go" />
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion" id="accordion3">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="searchThree">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#searchCollapseThree" aria-expanded="true" aria-controls="searchCollapseThree">
                                            Category
                                        </button>
                                    </h2>
                                    <div id="searchCollapseThree" class="accordion-collapse collapse show" aria-labelledby="searchThree" data-bs-parent="#accordion3">
                                        <div class="accordion-body">
                                            <div class="accordion-inner clearfix">
                                                <ul class="list-unstyled">
                                                   
                                                @foreach ($categories as $category)
                                                   @php  $cSelected = '';
                                                    if (in_array($category->id, $category_ids)) {
                                                        $cSelected = 'checked';
                                                    }
                                                    @endphp

                                                    @if($childEnd)
                                                    <li> <a href="{{url('search-property?c=' . $category->slug)}}"> <label for="make_{{$category->id}}" class='title text-link'> {{$category->name}} </label><span class='count'><small>{{$category->counter}} </small></span></a></li>
                                                    @else 
                                                   <li> <input data-name="{{$category->name}}" data-id="{{$category->id}}" class='categoryList'  {{$cSelected}} type='checkbox' value="{{$category->slug}}" name='c' id="make_{{$category->id}}"><label for="make_{{$category->id}}" class='title text-link'> {{$category->name}} </label><span class='count'><small>{{$category->counter}} </small></span></li>
                                                    @endif
                                                @endforeach

                                                   
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            
<div class="col-xl-12 content-box ">
                <div class="row row-featured row-featured-category">
                    <div class="col-xl-12  box-title no-border">
                        <div class="inner"><h2><span>Browse by</span>
                            Category <a href="/search" class="sell-your-item"> View more <i
                                    class="  icon-th-list"></i> </a></h2>
                        </div>
                    </div>

                    @foreach($categories as $category)

                    <?php 
                    if(!empty($category->picture))  { 
                        $imagename =  $category->picture;
                        $imagename = str_replace($category->id , $category->id . "/resize" , $imagename);
                        $categoryPhoto =  asset("storage/$imagename");    
                    ?>

                    <div class="col-xl-2 col-md-3 col-sm-3 col-xs-4 f-category">
                        <a href="{{url('category/' . $category->slug)}}"><img src="{{ $categoryPhoto}}" class="img-responsive" alt="img">
                            <h6> {!!$category->name!!} </h6></a>
                    <?php } else { ?> 
                        <a href="{{url('category/' . $category->slug)}}">
                            <h6> {!!$category->name!!} </h6></a>
                        <?php } ?>
                    </div>
                    @endforeach
                </div>


            </div>
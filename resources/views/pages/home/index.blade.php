@extends('mainPart.mainBody')
@section('mainContent')
   {{-- content --}}
<div data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-root-margin="0px 0px -40%" data-bs-smooth-scroll="true" class="scrollspy-example" tabindex="0">
    <div class="head-content shadow" id="pagePromotion">
      

       

        {{-- content banner --}}
        <div class="child-content">
            <div class="container">
    
                <div class="web text-light mb-3">
                    <div class="font-style-3 large-text">
                        Selamat Datang Kawan
                    </div>
                    <div>Website Kami menjual produk-produk, website kami akan melayani pembelanjaan anda. Silahkan menikmati belanja anda dan Keep Enjoy.</div>
                </div>
        
                {{-- carousel banner --}}
                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @php
                            $i = 0;
                        @endphp
                        @foreach ($carousels as $carousel)
                            @php
                                 if ($i==0) {
                                    $active = 'active';
                                }
                                else{
                                    $active = "";
                                }

                                $i++;
                            @endphp
                            <div class="carousel-item <?= $active; ?>">
                            <div class="carousel-content">
                                <div class="row body shadow">
                                    <div class="web col-5 dark-color">
                                        <div class="large-text font-style-2">
                                            {{ $carousel['subject']}}
                                        </div>
                                        <div>
                                            {{ $carousel['description'] }}
                                        </div>
                                    </div>
        
                                    <div class="col-lg-7">
                                        <div class="row">
                                            
                                            <div class="col-12">
                                                <img src="{{ asset($carousel['image']) }}" alt="" style="object-fit: cover; object-position: 15% 10%;">
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>


                        @endforeach
                       
                        
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                {{-- end carousel banner --}}
            </div>
        </div>

        {{-- end content banner --}}
    </div>


    @if (count($recommendation) > 0)
        
        <div class="main-content container mb-5" id="pageRecommendation">
            <div class="row dark-color mb-5">
                <div class="col-12 text-center">
                    <div class="font-style-3 large-text">
                        Recommendation
                    </div>  
                    <div>Lorem ipsum dolor sit amet consectetur, adipisicing elit. 
                        Nobis consequatur soluta cumque expedita ab corporis vero 
                        voluptates! Voluptatibus, quia similique repudiandae veniam 
                        nobis, iste culpa commodi quae esse quasi optio sunt assumenda 
                        quam neque nam explicabo ut ea officiis necessitatibus.
                        </div> 
                </div>        
            </div>
            
            {{-- item card --}}
            @php
                $set_item_card = [
                    'mobile_column' => 'col-6',
                    'web_column' => 'col-lg-2',
                    'item_data' => $recommendation 
                ];
            @endphp
            @include('part.item.itemCard',$set_item_card)
            {{-- end item card --}}

        </div>
    @endif
    
    <div class="middle-content mb-5" id="pageKategori">
         <div class="container">
             <div class="row mb-3 mb-lg-5">
                 <div class="title col-12 text-center">
                     <div class="font-style-3 large-text">
                         Kategori Product
                     </div>
                     <div>
                         Teman-teman juga dapat melihat produk-produk di kategori kami.
                     </div>
                 </div>
             </div>
             @php
                $align_style = '';
                 if($categories->count() <= 3){
                    $align_style = 'justify-content-center';
                 }
             @endphp

             <div class="row category-content {{ $align_style }}">
                <div class="col-lg-3 mb-3">
                        <a href="/#pageProduct" >
                            <div class="position-relative shadow">
                                <div class="box-body">
                                    <img src="{{asset('assets/images/img_situs/all_category.jpg') }}" alt="" style="object-fit: cover; object-position: 15% 10%;">
                                </div> 
                                <div class="overlay" style="border-radius: 0.5rem;">
                                    <div class="font-style-2 large-text position-absolute top-50 start-50 translate-middle">
                                        All Product
                                    </div>  
                                </div>       
                            </div>
                        </a>  
                    </div> 
                @foreach ($categories as $category)
                   <div class="col-lg-3 mb-3">
                        <a href="/?category={{ $category->slug }}#pageProduct" >
                            <div class="position-relative shadow">
                                <div class="box-body">
                                    <img src="{{asset($category->category_image) }}" alt="" style="object-fit: cover; object-position: 15% 10%;">
                                </div> 
                                <div class="overlay" style="border-radius: 0.5rem;">
                                    <div class="font-style-2 large-text position-absolute top-50 start-50 translate-middle">
                                        {{ $category->category_name }}
                                    </div>  
                                </div>       
                            </div>
                        </a>  
                    </div>     
                @endforeach
                 
             </div>
         </div>                      
    </div>
    
    
    <div class="main-content container mb-5" id="pageProduct">
        <div class="row dark-color mb-5">
            <div class="col-12 text-center">
                 <div class="font-style-3 large-text">
                    List Product
                 </div>  
                 <div>Lorem ipsum dolor sit amet consectetur, adipisicing elit. 
                     Nobis consequatur soluta cumque expedita ab corporis vero 
                     voluptates! Voluptatibus, quia similique repudiandae veniam 
                     nobis, iste culpa commodi quae esse quasi optio sunt assumenda 
                     quam neque nam explicabo ut ea officiis necessitatibus.
                    </div> 
            </div>        
        </div>
        
        {{-- item card --}}
        @php
            $set_item_card = [
                'mobile_column' => 'col-6',
                'web_column' => 'col-lg-2',
                'item_data' => $items 
            ];
        @endphp
        @include('part.item.itemCard',$set_item_card)
        {{-- end item card --}}

        <div class="d-flex justify-content-center d-lg-block mt-3">
            
                {{ $items->links() }}
            
        </div>
    </div>
    
    <div class="tail-content show" id="pageAbout">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <div class="font-style-3 large-text mb-2">
                        About us
                    </div>
                    <div>
                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. 
                        Blanditiis eius dolor sapiente ratione maiores omnis 
                        praesentium asperiores dolores quos illum! Earum nesciunt
                         accusantium quaerat nihil ipsum maiores ut voluptatum 
                         cupiditate. Asperiores, maiores illum? Exercitationem 
                         repellendus blanditiis ea assumenda suscipit placeat, 
                         vel cupiditate quidem at voluptatibus. Praesentium fugit
                          animi culpa officiis dolore iusto quae repellat laudantium, 
                          dicta amet maxime, rerum eaque nesciunt unde autem. Soluta,
                           magni veritatis consequatur aliquid temporibus amet 
                           nostrum natus sit dicta ex totam corporis cumque debitis 
                           quia ducimus? Tempore nostrum tenetur voluptatum ratione 
                           nisi dignissimos veritatis optio repellendus,
                            et esse quos sint neque soluta, accusamus aliquid voluptate.
                    </div>
                </div>
            </div>
        
            <div class="web row">
                <div class="col-12">
                    <div class="row mb-5">
                        <div class="col-4">
                            <img class="shadow" src="{{ asset('assets/images/img_situs/img5.jpeg') }}" alt="" style="width: 100% ; height:25rem; object-fit: cover; object-position: 15% 10%;">
                        </div>
                        <div class="col-8">
                            <div class="font-style-2 large-text">
                                About 1
                            </div>
                            <div>
    
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                                Perspiciatis nihil quis facere at odio porro obcaecati, 
                                delectus, exercitationem iste ea rerum eveniet ratione 
                                enim laboriosam provident placeat reprehenderit. 
                                Excepturi tenetur molestiae similique et, molestias
                                deserunt minus enim possimus voluptatum optio provident 
                                inventore ipsam exercitationem hic itaque eaque repudiandae aliquid nihil!
                            </div>
                        </div>
                    </div>
    
                    <div class="row mb-5">
                        <div class="col-8">
                            <div class="font-style-2 large-text">
                                About 2
                            </div>
                            <div>
    
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                                Perspiciatis nihil quis facere at odio porro obcaecati, 
                                delectus, exercitationem iste ea rerum eveniet ratione 
                                enim laboriosam provident placeat reprehenderit. 
                                Excepturi tenetur molestiae similique et, molestias
                                deserunt minus enim possimus voluptatum optio provident 
                                inventore ipsam exercitationem hic itaque eaque repudiandae aliquid nihil!
                            </div>
                        </div>
                        <div class="col-4">
                            <img class="shadow" src="{{ asset('assets/images/img_situs/img6.jpg') }}" alt="" style="width: 100%; height:25rem; object-fit: cover; object-position: 15% 10%;">
                        </div>
                        
                    </div>
    
                    <div class="row mb-5">
                        <div class="col-4">
                            <img class="shadow" src="{{ asset('assets/images/img_situs/img7.jpg') }}" alt="" style="width: 100%; height:25rem; object-fit: cover; object-position: 15% 10%;">
                        </div>
                        <div class="col-8">
                            <div class="font-style-2 large-text">
                                About 3
                            </div>
                            <div>
    
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                                Perspiciatis nihil quis facere at odio porro obcaecati, 
                                delectus, exercitationem iste ea rerum eveniet ratione 
                                enim laboriosam provident placeat reprehenderit. 
                                Excepturi tenetur molestiae similique et, molestias
                                deserunt minus enim possimus voluptatum optio provident 
                                inventore ipsam exercitationem hic itaque eaque repudiandae aliquid nihil!
                            </div>
                        </div>
                    </div>
                </div>   
            </div>
        </div>
    </div>
</div> 


<script>

    $(document).ready(() => {
    //     $(window).on('scroll', function() {
    //     var height_nav = $("#main-navigate").height();
    //     var y_scroll_pos = Number(window.pageYOffset) + Number(height_nav);
    //     var product_position = Number($('#pageProduct').offset().top) ;
    //     var about_position = Number($('#pageAbout').offset().top);
    //     var category_position = Number($('#pageKategori').offset().top);
    //     var rommended_position = Number($('#pageRecommendation').offset().top);
    //     // var scroll_pos_test = element_position;
        
    //      // page category
    //      if(rommended_position){
    //          if(y_scroll_pos > rommended_position - 300) {
    //            $("#pageRecommendation").addClass("show");  
    //            $("#pageRecommendation").removeClass("hide");
                 
    //          }
    //          else{
    //            console.log("is not here");
    //            $("#pageRecommendation").removeClass("show");  
    //            $("#pageRecommendation").addClass("hide");
    //          }
    //      }

    //      // page category
    //      if(category_position){
    //          if(y_scroll_pos > category_position - 300) {
    //            $("#pageKategori").addClass("show");  
    //            $("#pageKategori").removeClass("hide");
                 
    //          }
    //          else{
    //            console.log("is not here");
    //            $("#pageKategori").removeClass("show");  
    //            $("#pageKategori").addClass("hide");
    //          }
    //      }


    //     // page product
    //     if(product_position){

    //         if(y_scroll_pos > product_position - 300) {
    //           $("#pageProduct").addClass("show");  
    //           $("#pageProduct").removeClass("hide");
                
    //         }
    //         else{
    //           console.log("is not here");
    //           $("#pageProduct").removeClass("show");  
    //           $("#pageProduct").addClass("hide");
    //         }
    //     }

    //     // page about
    //     if(about_position){
    //         if(y_scroll_pos > about_position - 300) {
    //           $("#pageAbout").addClass("show");  
    //           $("#pageAbout").removeClass("hide");
    //           console.log("is here");  
    //         }
    //         else{
    //           console.log("is not here");
    //           $("#pageAbout").removeClass("show");  
    //           $("#pageAbout").addClass("hide");
    //         }
    //     }
    // });
    })


</script>
@endsection

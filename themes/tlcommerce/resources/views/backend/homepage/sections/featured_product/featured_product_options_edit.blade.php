 @if (isActivePluging('tlecommercecore'))
     @php
         $products = Plugin\TlcommerceCore\Models\Product::select('id', 'name')->get();
     @endphp
     <ul class="nav nav-tabs mb-20" id="myTab" role="tablist">
         <li class="nav-item">
             <a class="nav-link active" id="content-info-tab" data-toggle="tab" href="#content-info" role="tab"
                 aria-controls="content-info" aria-selected="true">{{ translate('Content') }}</a>
         </li>
         <li class="nav-item">
             <a class="nav-link" id="background-tab" data-toggle="tab" href="#background" role="tab"
                 aria-controls="background" aria-selected="false">{{ translate('Background') }}</a>
         </li>
         <li class="nav-item">
             <a class="nav-link" id="button-tab" data-toggle="tab" href="#button" role="tab" aria-controls="button"
                 aria-selected="false">{{ translate('Button') }}</a>
         </li>
         <li class="nav-item">
             <a class="nav-link" id="advanced-tab" data-toggle="tab" href="#advanced" role="tab"
                 aria-controls="button" aria-selected="false">{{ translate('Advanced') }}</a>
         </li>
     </ul>
     <div class="tab-content" id="myTabContent">
         <!--General info-->
         <div class="tab-pane fade show active" id="content-info" role="tabpanel" aria-labelledby="content-info-tab">

             <div class="form-row mb-20 layout-option product_collection">
                 <div class="col-sm-12">
                     <label class="font-14 bold black">{{ translate('Select Product') }}</label>
                 </div>
                 <div class="col-sm-12">
                     @if (count($products) > 0)
                         <select class="theme-input-style" name="product_id">
                             @foreach ($products as $product)
                                 <option value="{{ $product->id }}" @selected(getHomePageSectionProperties($details->id, 'product_id') == $product->id)>
                                     {{ $product->translation('name', getLocale()) }}
                                 </option>
                             @endforeach
                         </select>
                     @endif
                     @if ($errors->has('product_id'))
                         <div class="invalid-input">{{ $errors->first('product_id') }}</div>
                     @endif
                 </div>
             </div>
             <div class="form-row mb-20">
                 <div class="col-sm-12">
                     <label class="font-14 bold black">{{ translate('Featured Product Image') }} </label>
                 </div>
                 <div class="col-md-12">
                     @include('core::base.includes.media.media_input', [
                         'input' => 'cta_image',
                         'data' => getHomePageSectionProperties($details->id, 'cta_image'),
                     ])
                     @if ($errors->has('cta_image'))
                         <div class="invalid-input">{{ $errors->first('cta_image') }}</div>
                     @endif
                 </div>
             </div>
             <div class="form-row mb-20">
                 <div class="col-sm-12">
                     <label class="font-14 bold black">{{ translate('Video url') }} </label>
                 </div>
                 <div class="col-sm-12">
                     <div class="input-group addon">
                         <input type="text" name="video_url" class="theme-input-style"
                             placeholder="Youtube video link"
                             value="{{ getHomePageSectionProperties($details->id, 'video_url') }}">

                     </div>
                     @if ($errors->has('video_url'))
                         <div class="invalid-input">{{ $errors->first('video_url') }}</div>
                     @endif
                 </div>
             </div>
             <div class="form-row mb-20">
                 <div class="col-sm-12">
                     <label class="font-14 bold black">{{ translate('Meta Title') }} </label>
                 </div>
                 <div class="col-sm-12">
                     <div class="input-group addon">
                         <input type="text" name="meta_title" class="theme-input-style"
                             value="{{ getHomePageSectionProperties($details->id, 'meta_title') }}"
                             placeholder="Meta Title" required>

                     </div>
                     @if ($errors->has('meta_title'))
                         <div class="invalid-input">{{ $errors->first('meta_title') }}</div>
                     @endif
                     <small>{{ translate('Meta title is visible in homepage. Transalate to another language') }} <a
                             href="{{ route('core.languages') }}">{{ translate('click here') }}.</a></small>
                 </div>
             </div>
             <div class="form-row mb-20">
                 <div class="col-sm-12">
                     <label class="font-14 bold black">{{ translate('Title') }} </label>
                 </div>
                 <div class="col-sm-12">
                     <div class="input-group addon">
                         <input type="text" name="title"
                             value="{{ getHomePageSectionProperties($details->id, 'title') }}"
                             class="theme-input-style" placeholder="Title" required>

                     </div>
                     @if ($errors->has('title'))
                         <div class="invalid-input">{{ $errors->first('title') }}</div>
                     @endif
                     <small>{{ translate('Title is visible in homepage. Transalate to another language') }} <a
                             href="{{ route('core.languages') }}">{{ translate('click here') }}.</a></small>
                 </div>
             </div>
             <div class="form-row mb-20">
                 <div class="col-sm-12">
                     <label class="font-14 bold black">{{ translate('Paragraph') }} </label>
                 </div>
                 <div class="col-sm-12">
                     <div class="input-group addon">
                         <input type="text" name="featured_title" class="theme-input-style"
                             placeholder="{{ translate('Paragraph') }}"
                             value="{{ getHomePageSectionProperties($details->id, 'featured_title') }}">

                     </div>
                     @if ($errors->has('featured_title'))
                         <div class="invalid-input">{{ $errors->first('featured_title') }}</div>
                     @endif
                     <small>{{ translate('Paragraph is visible in homepage. Transalate to another language') }} <a
                             href="{{ route('core.languages') }}">{{ translate('click here') }}.</a></small>
                 </div>
             </div>

             <div class="form-row mb-20">
                 <div class="col-sm-12">
                     <label class="font-14 bold black">{{ translate('Title Color') }} </label>
                 </div>
                 <div class="col-sm-12">
                     <div class="input-group addon">
                         <input type="text" name="title_color" class="color-input form-control style--two"
                             placeholder="#fffff"
                             value="{{ getHomePageSectionProperties($details->id, 'title_color') }}">
                         <div class="input-group-append">
                             <input type="color" class="input-group-text theme-input-style2 color-picker"
                                 id="colorPicker"
                                 value="{{ getHomePageSectionProperties($details->id, 'title_color') }}"
                                 oninput="selectColor(event,this.value)">
                         </div>
                     </div>
                     @if ($errors->has('title_color'))
                         <div class="invalid-input">{{ $errors->first('title_color') }}</div>
                     @endif
                 </div>
             </div>
         </div>
         <!--End general info-->
         <!--Background-->
         <div class="tab-pane fade" id="background" role="tabpanel" aria-labelledby="background-tab">
             @include('theme/tlcommerce::backend.homepage.properties.background_properties_edit', [
                 'section_id' => $details->id,
             ])
         </div>
         <!--End background-->
         <!--Button-->
         <div class="tab-pane fade" id="button" role="tabpanel" aria-labelledby="button-tab">
             <div class="form-row mb-20">
                 <div class="col-sm-12">
                     <label class="font-14 bold black">{{ translate('Button Title') }} </label>
                 </div>
                 <div class="col-sm-12">
                     <input type="text" name="btn_title" class="theme-input-style"
                         value="{{ getHomePageSectionProperties($details->id, 'btn_title') }}"
                         placeholder="{{ translate('Button Title') }}" required>
                     @if ($errors->has('btn_title'))
                         <div class="invalid-input">{{ $errors->first('btn_title') }}</div>
                     @endif
                     <small>
                         {{ translate('Button title is visible in homepage. Transalate to another language') }} <a
                             href="{{ route('core.languages') }}">{{ translate('click here') }}.</a>
                     </small>
                 </div>
             </div>
             <div class="form-row mb-20">
                 <div class="col-sm-12">
                     <label class="font-14 bold black">{{ translate('Play Button Color') }} </label>
                 </div>
                 <div class="col-sm-12">
                     <div class="input-group addon">
                         <input type="text" name="play_btn_color" class="color-input form-control style--two"
                             placeholder="#fffff"
                             value="{{ getHomePageSectionProperties($details->id, 'play_btn_color') }}">
                         <div class="input-group-append">
                             <input type="color" class="input-group-text theme-input-style2 color-picker"
                                 id="colorPicker"
                                 value="{{ getHomePageSectionProperties($details->id, 'play_btn_color') }}"
                                 oninput="selectColor(event,this.value)">
                         </div>
                     </div>
                     @if ($errors->has('play_btn_color'))
                         <div class="invalid-input">{{ $errors->first('play_btn_color') }}</div>
                     @endif
                 </div>
             </div>
             <div class="form-row mb-20">
                 <div class="col-sm-12">
                     <label class="font-14 bold black">{{ translate('Play Button Border Color') }} </label>
                 </div>
                 <div class="col-sm-12">
                     <div class="input-group addon">
                         <input type="text" name="play_btn_border_color"
                             class="color-input form-control style--two" placeholder="#fffff"
                             value="{{ getHomePageSectionProperties($details->id, 'play_btn_border_color') }}">
                         <div class="input-group-append">
                             <input type="color" class="input-group-text theme-input-style2 color-picker"
                                 id="colorPicker"
                                 value="{{ getHomePageSectionProperties($details->id, 'play_btn_border_color') }}"
                                 oninput="selectColor(event,this.value)">
                         </div>
                     </div>
                     @if ($errors->has('play_btn_border_color'))
                         <div class="invalid-input">{{ $errors->first('play_btn_border_color') }}</div>
                     @endif
                 </div>
             </div>
             @include('theme/tlcommerce::backend.homepage.properties.button_properties_edit', [
                 'section_id' => $details->id,
             ])
         </div>
         <!--End button-->
         <!--Advanced-->
         <div class="tab-pane fade" id="advanced" role="tabpanel" aria-labelledby="advanced-tab">
             @include('theme/tlcommerce::backend.homepage.properties.advance_properties_edit', [
                 'section_id' => $details->id,
             ])
         </div>
         <!--End advance-->
     </div>
 @endif

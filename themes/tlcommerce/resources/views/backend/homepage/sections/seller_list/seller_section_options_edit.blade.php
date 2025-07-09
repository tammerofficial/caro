 @if (isActivePluging('tlecommercecore'))
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
         <div class="tab-pane fade show active" id="content-info" role="tabpanel" aria-labelledby="content-info-tab">
             <!--Seller List-->
             <div class="form-row mb-20">
                 @php
                     $seller_string = getHomePageSectionProperties($details->id, 'content');
                     $sellers = \Core\Models\user::whereIn('id', explode(',', $seller_string))
                         ->select('name', 'id')
                         ->get();
                 @endphp
                 <div class="col-sm-12">
                     <label class="font-14 bold black">{{ translate('Select Sellers') }}</label>
                 </div>
                 <div class="col-sm-12">
                     <select class="theme-input-style seller-selector" name="sellers[]" multiple required>
                         @if ($sellers != null)
                             @foreach ($sellers as $seller)
                                 <option value="{{ $seller->id }}" selected>{{ $seller->name }}</option>
                             @endforeach
                         @endif
                     </select>

                     @if ($errors->has('content'))
                         <div class="invalid-input">{{ $errors->first('content') }}</div>
                     @endif
                 </div>
             </div>
             <!--End Seller List-->
             <div class="form-row mb-20">
                 <div class="col-sm-12">
                     <label class="font-14 bold black"> {{ translate('Banner Option') }} </label>
                 </div>
                 <div class="col-sm-12">
                     <select class="theme-input-style" name="banner_option" required>
                         <option value="with_banner" @selected(getHomePageSectionProperties($details->id, 'banner_option') == 'with_banner')>{{ translate('With Banner') }}
                         </option>
                         <option value="without_banner" @selected(getHomePageSectionProperties($details->id, 'banner_option') == 'without_banner')>{{ translate('Without Banner') }}
                         </option>
                     </select>
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
                     <small>{{ translate('Title is not visible in homepage') }}</small>
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

         <div class="tab-pane fade" id="background" role="tabpanel" aria-labelledby="background-tab">
             @include('theme/tlcommerce::backend.homepage.properties.background_properties_edit', [
                 'section_id' => $details->id,
             ])
         </div>

         <div class="tab-pane fade" id="button" role="tabpanel" aria-labelledby="button-tab">
             <div class="form-row mb-20">
                 <div class="col-sm-12">
                     <label class="font-14 bold black">{{ translate('Button Title') }} </label>
                 </div>
                 <div class="col-sm-12">
                     <input type="text" name="btn_title" class="theme-input-style"
                         value="{{ getHomePageSectionProperties($details->id, 'btn_title') }}"
                         placeholder="{{ translate('Button Title') }}">
                     @if ($errors->has('btn_title'))
                         <div class="invalid-input">{{ $errors->first('btn_title') }}</div>
                     @endif
                     <small>{{ translate('Button title is visible in homepage. Transalate to another language') }} <a
                             href="{{ route('core.languages') }}">{{ translate('click here') }}.</a></small>
                 </div>
             </div>
             @include('theme/tlcommerce::backend.homepage.properties.button_properties_edit', [
                 'section_id' => $details->id,
             ])
         </div>

         <div class="tab-pane fade" id="advanced" role="tabpanel" aria-labelledby="advanced-tab">
             @include('theme/tlcommerce::backend.homepage.properties.advance_properties_edit', [
                 'section_id' => $details->id,
             ])
         </div>
     </div>
 @endif

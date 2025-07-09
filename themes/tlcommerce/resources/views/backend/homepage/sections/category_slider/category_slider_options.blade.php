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
             <a class="nav-link" id="advanced-tab" data-toggle="tab" href="#advanced" role="tab"
                 aria-controls="button" aria-selected="false">{{ translate('Advanced') }}</a>
         </li>
     </ul>
     <div class="tab-content" id="myTabContent">

         <div class="tab-pane fade show active" id="content-info" role="tabpanel" aria-labelledby="content-info-tab">
             <div class="form-row mb-20">
                 <div class="col-sm-12">
                     <label class="font-14 bold black">{{ translate('Title') }} </label>
                 </div>
                 <div class="col-sm-12">
                     <div class="input-group addon">
                         <input type="text" name="title" class="theme-input-style" placeholder="Title" required>

                     </div>
                     @if ($errors->has('title'))
                         <div class="invalid-input">{{ $errors->first('title') }}</div>
                     @endif
                     <small>{{ translate('Title is not visible in homepage') }}</small>
                 </div>
             </div>
         </div>

         <div class="tab-pane fade" id="background" role="tabpanel" aria-labelledby="background-tab">
             @include('theme/tlcommerce::backend.homepage.properties.background_properties_add')
         </div>
         <div class="tab-pane fade" id="advanced" role="tabpanel" aria-labelledby="advanced-tab">
             @include('theme/tlcommerce::backend.homepage.properties.advance_properties_add')
         </div>
     </div>
 @endif

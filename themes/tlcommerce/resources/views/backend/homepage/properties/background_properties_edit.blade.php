 <div class="form-row mb-20">
     <div class="col-sm-12">
         <label class="font-14 bold black">{{ translate('Background Color') }} </label>
     </div>
     <div class="col-sm-12">
         <div class="input-group addon">
             <input type="text" name="bg_color" class="color-input form-control style--two" placeholder="#fffff"
                 value="{{ getHomePageSectionProperties($section_id, 'bg_color') }}">
             <div class="input-group-append">
                 <input type="color" class="input-group-text theme-input-style2 color-picker" id="colorPicker"
                     value="{{ getHomePageSectionProperties($section_id, 'bg_color') }}"
                     oninput="selectColor(event,this.value)">
             </div>
         </div>
         @if ($errors->has('bg_color'))
             <div class="invalid-input">{{ $errors->first('bg_color') }}</div>
         @endif
     </div>
 </div>
 <div class="form-row mb-20">
     <div class="col-sm-12">
         <label class="font-14 bold black">{{ translate('Background Image') }} </label>
     </div>
     <div class="col-md-12">
         @include('core::base.includes.media.media_input', [
             'input' => 'bg_image',
             'data' => getHomePageSectionProperties($section_id, 'bg_image'),
         ])
         @if ($errors->has('bg_image'))
             <div class="invalid-input">{{ $errors->first('bg_image') }}</div>
         @endif
     </div>
 </div>
 <div class="form-row mb-20">
     <div class="col-sm-12">
         <label class="font-14 bold black"> {{ translate('Background Size') }} </label>
     </div>
     <div class="col-sm-12">
         <select class="theme-input-style" name="background_size">
             <option value="cover" @selected(getHomePageSectionProperties($section_id, 'background_size') == 'cover')>{{ translate('cover') }}</option>
             <option value="auto" @selected(getHomePageSectionProperties($section_id, 'background_size') == 'auto')>{{ translate('auto') }}</option>
             <option value="contain" @selected(getHomePageSectionProperties($section_id, 'background_size') == 'contain')>{{ translate('contain') }}</option>
             <option value="initial" @selected(getHomePageSectionProperties($section_id, 'background_size') == 'initial')>{{ translate('initial') }}</option>
             <option value="revert" @selected(getHomePageSectionProperties($section_id, 'background_size') == 'revert')>{{ translate('revert') }}</option>
             <option value="inherit" @selected(getHomePageSectionProperties($section_id, 'background_size') == 'inherit')>{{ translate('inherit') }}</option>
             <option value="revert-layer" @selected(getHomePageSectionProperties($section_id, 'background_size') == 'revert-layer')>{{ translate('revert-layer') }}
             </option>
             <option value="unset" @selected(getHomePageSectionProperties($section_id, 'background_size') == 'unset')>{{ translate('unset') }}</option>
         </select>
         @if ($errors->has('background_size'))
             <div class="invalid-input">{{ $errors->first('background_size') }}</div>
         @endif
     </div>
 </div>
 <div class="form-row mb-20">
     <div class="col-sm-12">
         <label class="font-14 bold black"> {{ translate('Background Position') }} </label>
     </div>
     <div class="col-sm-12">
         <select class="theme-input-style" name="background_position">
             <option value="bottom" @selected(getHomePageSectionProperties($section_id, 'background_position') == 'bottom')>{{ translate('bottom') }}</option>
             <option value="center" @selected(getHomePageSectionProperties($section_id, 'background_position') == 'center')>{{ translate('center') }}</option>
             <option value="inherit" @selected(getHomePageSectionProperties($section_id, 'background_position') == 'inherit')>{{ translate('inherit') }}</option>
             <option value="initial" @selected(getHomePageSectionProperties($section_id, 'background_position') == 'initial')>{{ translate('initial') }}</option>
             <option value="left" @selected(getHomePageSectionProperties($section_id, 'background_position') == 'left')>{{ translate('left') }}</option>
             <option value="revert" @selected(getHomePageSectionProperties($section_id, 'background_position') == 'revert')>{{ translate('revert') }}</option>
             <option value="revert-layer" @selected(getHomePageSectionProperties($section_id, 'background_position') == 'revert-layer')>{{ translate('revert-layer') }}
             </option>
             <option value="right" @selected(getHomePageSectionProperties($section_id, 'background_position') == 'right')>{{ translate('right') }}</option>
             <option value="top" @selected(getHomePageSectionProperties($section_id, 'background_position') == 'top')>{{ translate('top') }}</option>
             <option value="unset" @selected(getHomePageSectionProperties($section_id, 'background_position') == 'unset')>{{ translate('unset') }}</option>
         </select>
         @if ($errors->has('background_position'))
             <div class="invalid-input">{{ $errors->first('background_position') }}</div>
         @endif
     </div>
 </div>
 <div class="form-row mb-20">
     <div class="col-sm-12">
         <label class="font-14 bold black"> {{ translate('Background Repeat') }} </label>
     </div>
     <div class="col-sm-12">
         <select class="theme-input-style" name="background_repeat">
             <option value="no-repeat" @selected(getHomePageSectionProperties($section_id, 'background_repeat') == 'no-repeat')>no-repeat</option>
             <option value="repeat" @selected(getHomePageSectionProperties($section_id, 'background_repeat') == 'repeat')>repeat</option>
         </select>
         @if ($errors->has('background_repeat'))
             <div class="invalid-input">{{ $errors->first('background_repeat') }}</div>
         @endif
     </div>
 </div>

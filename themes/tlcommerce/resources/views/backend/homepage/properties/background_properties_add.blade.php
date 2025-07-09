<div class="form-row mb-20">
    <div class="col-sm-12">
        <label class="font-14 bold black">{{ translate('Background Color') }} </label>
    </div>
    <div class="col-sm-12">
        <div class="input-group addon">
            <input type="text" name="bg_color" class="color-input form-control style--two" placeholder="#fffff"
                value="#ffffff">
            <div class="input-group-append">
                <input type="color" class="input-group-text theme-input-style2 color-picker" id="colorPicker"
                    value="#ffffff" oninput="selectColor(event,this.value)">
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
            'data' => old('bg_image'),
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
            <option value="cover">cover</option>
            <option value="auto">auto</option>
            <option value="contain">contain</option>
            <option value="initial">initial</option>
            <option value="revert">revert</option>
            <option value="inherit">inherit</option>
            <option value="revert-layer">revert-layer</option>
            <option value="unset">unset</option>
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
            <option value="bottom">bottom</option>
            <option value="center">center</option>
            <option value="inherit">inherit</option>
            <option value="initial">initial</option>
            <option value="left">left</option>
            <option value="revert">revert</option>
            <option value="revert-layer">revert-layer</option>
            <option value="right">right</option>
            <option value="top">top</option>
            <option value="unset">unset</option>
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
            <option value="no-repeat">no-repeat</option>
            <option value="repeat">repeat</option>
        </select>
        @if ($errors->has('background_repeat'))
            <div class="invalid-input">{{ $errors->first('background_repeat') }}</div>
        @endif
    </div>
</div>

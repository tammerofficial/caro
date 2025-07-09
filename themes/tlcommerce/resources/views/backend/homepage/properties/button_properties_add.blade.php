<div class="form-row mb-20">
    <div class="col-sm-12">
        <label class="font-14 bold black">{{ translate('Button Color') }} </label>
    </div>
    <div class="col-sm-12">
        <div class="input-group addon">
            <input type="text" name="btn_color" class="color-input form-control style--two" placeholder="#ffffff"
                value="#ffffff">
            <div class="input-group-append">
                <input type="color" class="input-group-text theme-input-style2 color-picker" id="colorPicker"
                    value="#ffffff" oninput="selectColor(event,this.value)">
            </div>
        </div>
        @if ($errors->has('btn_color'))
            <div class="invalid-input">{{ $errors->first('btn_color') }}</div>
        @endif
    </div>
</div>
<div class="form-row mb-20">
    <div class="col-sm-12">
        <label class="font-14 bold black">{{ translate('Button Hover Color') }} </label>
    </div>
    <div class="col-sm-12">
        <div class="input-group addon">
            <input type="text" name="btn_hover_color" class="color-input form-control style--two"
                placeholder="#ffffff" value="#ffffff">
            <div class="input-group-append">
                <input type="color" class="input-group-text theme-input-style2 color-picker" id="colorPicker"
                    value="#ffffff" oninput="selectColor(event,this.value)">
            </div>
        </div>
        @if ($errors->has('btn_hover_color'))
            <div class="invalid-input">{{ $errors->first('btn_hover_color') }}</div>
        @endif
    </div>
</div>
<div class="form-row mb-20">
    <div class="col-sm-12">
        <label class="font-14 bold black">{{ translate('Button Background Color') }} </label>
    </div>
    <div class="col-sm-12">
        <div class="input-group addon">
            <input type="text" name="btn_bg_color" class="color-input form-control style--two" placeholder="#ef2543"
                value="#ef2543">
            <div class="input-group-append">
                <input type="color" class="input-group-text theme-input-style2 color-picker" id="colorPicker"
                    value="#ef2543" oninput="selectColor(event,this.value)">
            </div>
        </div>
        @if ($errors->has('btn_bg_color'))
            <div class="invalid-input">{{ $errors->first('btn_bg_color') }}</div>
        @endif
    </div>
</div>
<div class="form-row mb-20">
    <div class="col-sm-12">
        <label class="font-14 bold black">{{ translate('Button Background Hover Color') }} </label>
    </div>
    <div class="col-sm-12">
        <div class="input-group addon">
            <input type="text" name="btn_bg_hover_color" class="color-input form-control style--two"
                placeholder="#22303f" value="#22303f">
            <div class="input-group-append">
                <input type="color" class="input-group-text theme-input-style2 color-picker" id="colorPicker"
                    value="#22303f" oninput="selectColor(event,this.value)">
            </div>
        </div>
        @if ($errors->has('btn_bg_hover_color'))
            <div class="invalid-input">{{ $errors->first('btn_bg_hover_color') }}</div>
        @endif
    </div>
</div>
<div class="form-row mb-20">
    <div class="col-sm-12">
        <label class="font-14 bold black">{{ translate('Button Border') }} </label>
    </div>
    <div class="col-sm-12">
        <div class="input-group addon">
            <input type="number" class="form-control radius-0" name="btn_border" placeholder="00" value="0">
            <div class="input-group-append">
                <span class="input-group-text style--three black bold">px</span>
            </div>
        </div>
        @if ($errors->has('btn_border'))
            <div class="invalid-input">{{ $errors->first('btn_border') }}</div>
        @endif
    </div>
</div>
<div class="form-row mb-20">
    <div class="col-sm-12">
        <label class="font-14 bold black">{{ translate('Button Border Color') }} </label>
    </div>
    <div class="col-sm-12">
        <div class="input-group addon">
            <input type="text" name="btn_border_color" class="color-input form-control style--two"
                placeholder="#ef2543" value="#ef2543">
            <div class="input-group-append">
                <input type="color" class="input-group-text theme-input-style2 color-picker" id="colorPicker"
                    value="#ef2543" oninput="selectColor(event,this.value)">
            </div>
        </div>
        @if ($errors->has('btn_border_color'))
            <div class="invalid-input">{{ $errors->first('btn_border_color') }}</div>
        @endif
    </div>
</div>
<div class="form-row mb-20">
    <div class="col-sm-12">
        <label class="font-14 bold black">{{ translate('Button Border Hover Color') }} </label>
    </div>
    <div class="col-sm-12">
        <div class="input-group addon">
            <input type="text" name="btn_border_hover_color" class="color-input form-control style--two"
                placeholder="#22303f" value="#22303f">
            <div class="input-group-append">
                <input type="color" class="input-group-text theme-input-style2 color-picker" id="colorPicker"
                    value="#22303f" oninput="selectColor(event,this.value)">
            </div>
        </div>
        @if ($errors->has('btn_border_hover_color'))
            <div class="invalid-input">{{ $errors->first('btn_border_hover_color') }}</div>
        @endif
    </div>
</div>

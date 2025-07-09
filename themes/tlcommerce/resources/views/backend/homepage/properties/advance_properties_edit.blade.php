<div class="form-row mb-20">
    <div class="col-sm-12">
        <label class="font-14 bold black">{{ translate('Padding') }} </label>
    </div>
    <div class="col-sm-3">
        <div class="input-group addon">
            <input type="text" class="form-control radius-0" name="padding_top" id="left-right-addons" placeholder="00"
                value="{{ getHomePageSectionProperties($section_id, 'padding_top') }}">
            <div class="input-group-append">
                <span class="input-group-text style--three black bold">px</span>
            </div>
        </div>
        <smal>{{ translate('Top') }}</smal>
        @if ($errors->has('padding_top'))
            <div class="invalid-input">{{ $errors->first('padding_top') }}</div>
        @endif
    </div>
    <div class="col-sm-3">
        <div class="input-group addon">
            <input type="text" class="form-control radius-0" name="padding_right" id="left-right-addons"
                placeholder="00" value="{{ getHomePageSectionProperties($section_id, 'padding_right') }}">
            <div class="input-group-append">
                <span class="input-group-text style--three black bold">px</span>
            </div>
        </div>
        <smal>{{ translate('Right') }}</smal>
        @if ($errors->has('padding_right'))
            <div class="invalid-input">{{ $errors->first('padding_right') }}</div>
        @endif
    </div>
    <div class="col-sm-3">
        <div class="input-group addon">
            <input type="text" class="form-control radius-0" name="padding_bottom" id="left-right-addons"
                placeholder="00" value="{{ getHomePageSectionProperties($section_id, 'padding_bottom') }}">
            <div class="input-group-append">
                <span class="input-group-text style--three black bold">px</span>
            </div>
        </div>
        <smal>{{ translate('Bottom') }}</smal>
        @if ($errors->has('padding_bottom'))
            <div class="invalid-input">{{ $errors->first('padding_bottom') }}</div>
        @endif
    </div>
    <div class="col-sm-3">
        <div class="input-group addon">
            <input type="text" class="form-control radius-0" name="padding_left" id="left-right-addons"
                placeholder="00" value="{{ getHomePageSectionProperties($section_id, 'padding_left') }}">
            <div class="input-group-append">
                <span class="input-group-text style--three black bold">px</span>
            </div>
        </div>
        <smal>{{ translate('Left') }}</smal>
        @if ($errors->has('padding_left'))
            <div class="invalid-input">{{ $errors->first('padding_left') }}</div>
        @endif
    </div>
</div>

<div class="form-row mb-20">
    <div class="col-sm-12">
        <label class="font-14 bold black">{{ translate('Margin') }} </label>
    </div>
    <div class="col-sm-3">
        <div class="input-group addon">
            <input type="text" class="form-control radius-0" name="margin_top" id="left-right-addons"
                placeholder="00" value="{{ getHomePageSectionProperties($section_id, 'margin_top') }}">
            <div class="input-group-append">
                <span class="input-group-text style--three black bold">px</span>
            </div>
        </div>
        <smal>{{ translate('Top') }}</smal>
        @if ($errors->has('margin_top'))
            <div class="invalid-input">{{ $errors->first('margin_top') }}</div>
        @endif
    </div>
    <div class="col-sm-3">
        <div class="input-group addon">
            <input type="text" class="form-control radius-0" name="margin_right" id="left-right-addons"
                placeholder="00" value="{{ getHomePageSectionProperties($section_id, 'margin_right') }}">
            <div class="input-group-append">
                <span class="input-group-text style--three black bold">px</span>
            </div>
        </div>
        <smal>{{ translate('Right') }}</smal>
        @if ($errors->has('margin_right'))
            <div class="invalid-input">{{ $errors->first('margin_right') }}</div>
        @endif
    </div>
    <div class="col-sm-3">
        <div class="input-group addon">
            <input type="text" class="form-control radius-0" name="margin_bottom" id="left-right-addons"
                placeholder="00" value=" {{ getHomePageSectionProperties($section_id, 'margin_bottom') }}">
            <div class="input-group-append">
                <span class="input-group-text style--three black bold">px</span>
            </div>
        </div>
        <smal>{{ translate('Bottom') }}</smal>
        @if ($errors->has('margin_bottom'))
            <div class="invalid-input">{{ $errors->first('margin_bottom') }}</div>
        @endif
    </div>
    <div class="col-sm-3">
        <div class="input-group addon">
            <input type="text" class="form-control radius-0" name="margin_left" id="left-right-addons"
                placeholder="00" value="{{ getHomePageSectionProperties($section_id, 'margin_left') }}">
            <div class="input-group-append">
                <span class="input-group-text style--three black bold">px</span>
            </div>
        </div>
        <smal>{{ translate('Left') }}</smal>
        @if ($errors->has('margin_left'))
            <div class="invalid-input">{{ $errors->first('margin_left') }}</div>
        @endif
    </div>
</div>

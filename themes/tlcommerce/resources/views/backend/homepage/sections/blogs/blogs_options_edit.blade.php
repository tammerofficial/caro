@php
    $blogCategories = \Core\Models\TlBlogCategory::where('is_publish', config('settings.general_status.active'))->get();
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
        <a class="nav-link" id="advanced-tab" data-toggle="tab" href="#advanced" role="tab" aria-controls="button"
            aria-selected="false">{{ translate('Advanced') }}</a>
    </li>
</ul>
<div class="tab-content" id="myTabContent">
    <!--General info-->
    <div class="tab-pane fade show active" id="content-info" role="tabpanel" aria-labelledby="content-info-tab">

        <div class="form-row mb-20">
            <div class="col-sm-12">
                <label class="font-14 bold black">{{ translate('Select Option') }}</label>
            </div>
            <div class="col-sm-12">
                <select class="theme-input-style blog-section-option" name="content" required
                    onchange="selectBlogsOption()">
                    <option value="latest" @selected(getHomePageSectionProperties($details->id, 'content') == 'latest')>{{ translate('Latest Blogs') }}</option>
                    <option value="featured" @selected(getHomePageSectionProperties($details->id, 'content') == 'featured')>{{ translate('Featured Blogs') }}</option>
                    <option value="category" @selected(getHomePageSectionProperties($details->id, 'content') == 'category')>{{ translate('Category wise') }}</option>
                </select>

                @if ($errors->has('content'))
                    <div class="invalid-input">{{ $errors->first('content') }}</div>
                @endif
            </div>
        </div>
        <div class="form-row mb-20 blog-option @if (getHomePageSectionProperties($details->id, 'content') != 'category') d-none @endif">
            <div class="col-sm-12">
                <label class="font-14 bold black">{{ translate('Select Category') }}</label>
            </div>
            <div class="col-sm-12">
                <select class="theme-input-style" name="category">
                    @foreach ($blogCategories as $category)
                        <option value="{{ $category->id }}" @selected(getHomePageSectionProperties($details->id, 'category') == $category->id)>{{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @if ($errors->has('category'))
                    <div class="invalid-input">{{ $errors->first('category') }}</div>
                @endif
            </div>
        </div>
        <div class="form-row mb-20">
            <div class="col-sm-12">
                <label class="font-14 bold black">{{ translate('Number of Blogs') }} </label>
            </div>
            <div class="col-sm-12">
                <input type="text" name="number_of_blogs" class="theme-input-style"
                    value="{{ getHomePageSectionProperties($details->id, 'number_of_blogs') }}" placeholder="00">
                @if ($errors->has('number_of_blogs'))
                    <div class="invalid-input">{{ $errors->first('number_of_blogs') }}</div>
                @endif
            </div>
        </div>

        <div class="form-row mb-20">
            <div class="col-sm-12">
                <label class="font-14 bold black">{{ translate('Title') }} </label>
            </div>
            <div class="col-sm-12">
                <div class="input-group addon">
                    <input type="text" name="title"
                        value="{{ getHomePageSectionProperties($details->id, 'title') }}" class="theme-input-style"
                        placeholder="Title" required>

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
                <label class="font-14 bold black">{{ translate('Title Color') }} </label>
            </div>
            <div class="col-sm-12">
                <div class="input-group addon">
                    <input type="text" name="title_color" class="color-input form-control style--two"
                        placeholder="#fffff" value="{{ getHomePageSectionProperties($details->id, 'title_color') }}">
                    <div class="input-group-append">
                        <input type="color" class="input-group-text theme-input-style2 color-picker" id="colorPicker"
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
                    placeholder="{{ translate('Button Title') }}">
                @if ($errors->has('btn_title'))
                    <div class="invalid-input">{{ $errors->first('btn_title') }}</div>
                @endif
                <small>{{ translate('Button title is visible in homepage. Transalate to another language') }}
                    <a href="{{ route('core.languages') }}">{{ translate('click here') }}</a>
                </small>
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
<script>
    function selectBlogsOption() {
        let layout = $(".blog-section-option").val();
        if (layout === 'category') {
            $('.blog-option').removeClass('d-none');
        } else {
            $('.blog-option').addClass('d-none');
        }
    }
</script>

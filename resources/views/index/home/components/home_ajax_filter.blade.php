<span class="totalRecords">{{$values['totalRecords']}} available records</span>                    
@include('Index::common.filters.basic', ['param' => $values['param'], 'femaleTotal' => $values['femaleTotal'], 'maleTotal' => $values['maleTotal'], 'bysexualTotal' => $values['bysexualTotal'], 'hetroTotal' => $values['hetroTotal'], 'ethnicityOptions' => $values['ethnicityOptions'], 'total_availability' => $values['total_availability'], 'verified' => $values['verified'], 'silver' => $values['silver'], 'gold' => $values['gold'] ])

@include('Index::common.filters.advance_search', ['param' => $values['param'], 'ethnicityOptions' => $values['ethnicityOptions'], 'cupSizeOptions' => $values['cupSizeOptions'], 'buildOptions' => $values['buildOptions'], 'hairLengthOptions' => $values['hairLengthOptions'], 'eyeColors' => $values['eyeColors'], 'publicHairs' => $values['publicHairs'], 'escortTypeOptions' => $values['escortTypeOptions'], 'originOptions' => $values['originOptions'], 'travelOptions' => $values['travelOptions'], 'smokeOptions' => $values['smokeOptions'], 'drinkOptions' => $values['drinkOptions'], 'total_with_video' => $values['total_with_video'], 'total_without_video' => $values['total_without_video'], 'total_with_review' => $values['total_with_review'], 'total_without_review' => $values['total_without_review'], 'languages' => $values['languages']])

@include('Index::common.filters.physical', ['param' => $values['param'], 'hairColors' => $values['hairColors'], 'cupSizeOptions' => $values['cupSizeOptions'], 'buildOptions' => $values['buildOptions'], 'hairLengthOptions' => $values['hairLengthOptions'], 'eyeColors' => $values['eyeColors'], 'publicHairs' => $values['publicHairs']])

@include('Index::common.filters.extra', ['param' => $values['param'], 'escortTypeOptions' => $values['escortTypeOptions'], 'originOptions' => $values['originOptions'], 'travelOptions' => $values['travelOptions'], 'smokeOptions' => $values['smokeOptions'], 'drinkOptions' => $values['drinkOptions'], 'total_with_video' => $values['total_with_video'], 'total_without_video' => $values['total_without_video'], 'total_with_review' => $values['total_with_review'], 'total_without_review' => $values['total_without_review']])

@include('Index::common.filters.languages', ['param' => $values['param'], 'languages' => $values['languages']])

@include('Index::common.filters.services', ['param' => $values['param'], 'escortServices' => $values['escortServices'], 'eroticServices' => $values['eroticServices'], 'fetishServices' => $values['fetishServices'], 'extraServices' => $values['extraServices'] ])

@include('Index::common.filterscripts')

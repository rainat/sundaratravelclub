(function ($) {
	const people_value = {
		value: 'no',
		checked: '',
		on:'display:none',
		off:'display:block',
		oninput:'',
		
	}
	
	if (typeof cuber_people_two ==='undefined') people_value.value = 'no'; else if (cuber_people_two === 'active') 
			{ 
				people_value.value = 'yes'; 
				people_value.checked = 'checked'; 
				people_value.on = 'display:block'
				people_value.off = 'display:none'
				people_value.oninput = 'onoff_checked'
				
			}  
	const switchOnOff =	`<style>.cuberaksi-container{display:flex;}</style><div class="cuberaksi-container"><label class="yith-wcbk-form-field__label" for="_yith_booking_has_persons">Cuberaksi People multiply two</label>
	<div class="yith-plugin-fw-onoff-container ">
	<input type="checkbox" id="_cuber_people_two" class="on_off ${people_value.oninput}" name="_cuber_people_two" value="${people_value.value}" ${people_value.checked} >
	<span class="yith-plugin-fw-onoff">
		<span class="yith-plugin-fw-onoff__handle">
			<svg style="${people_value.on}" class="yith-plugin-fw-onoff__icon yith-plugin-fw-onoff__icon--on" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" role="img">
				<path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
			</svg>
			<svg style="${people_value.off}" class="yith-plugin-fw-onoff__icon yith-plugin-fw-onoff__icon--off" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" role="img">
				<path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
			</svg>
		</span>
		<span class="yith-plugin-fw-onoff__zero-width-space notranslate">&ZeroWidthSpace;</span>
	</span>
</div></div>`
	$(document).ready(() => {
		if ($('._yith_booking_has_persons_field').length) 
			{
			 $('.yith-wcbk-form-field._yith_booking_has_persons_field').before(switchOnOff)
				
			
				
				
			}
	})
})(jQuery)
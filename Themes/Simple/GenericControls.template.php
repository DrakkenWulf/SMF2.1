<?php

/*
* Generic controls template
*
* License: http://www.opensource.org/licenses/mit-license.php
*/


//textarea used when posting messages (not used in quick reply however)
function template_control_richedit($editorId) {
  global $context;
  
  $editorContext = & $context['controls']['richedit'][$editorId];
  echo '<textarea class="editor" name="', $editorId, '" id="', $editorId, '" rows="', (isset($editorContext['rows']) ? $editorContext['rows'] : '1'), '" cols="', (isset($editorContext['columns']) ? $editorContext['columns'] : '60'), '" tabindex="', $context['tabindex']++, '" style="width: 100%;', (isset($context['post_error']['no_message']) || isset($context['post_error']['long_message']) ? 'border: 1px solid red;' : ''), '">', (isset($editorContext['value']) ? $editorContext['value'] : ''), '</textarea>';
}

//Verification control used throughout the theme
function template_control_verification($verify_id, $displayType = 'all', $reset = false) {
  global $context, $settings, $options, $txt, $modSettings;
  
  $verification = "";
  
  $verify_context = & $context['controls']['verification'][$verify_id];
  
  //Keep track of where we are
  if (empty($verify_context['tracking']) || $reset) {
    $verify_context['tracking'] = 0;
  }
  
  //How many items are there to display in total
  $totalItems = count($verify_context['questions']) + ($verify_context['show_visual'] ? 1 : 0);
  
  // If we've gone too far, stop
  if ($verify_context['tracking'] > $totalItems) return false;
  
  // Loop through each item to show them
  for ($i = 0; $i < $totalItems; $i++) {
    
    // If we're after a single item only show it if we're in the right place
    if ($displayType == 'single' && $verify_context['tracking'] != $i) continue;

    // Do the actual stuff - image first?
    if ($i == 0 && $verify_context['show_visual']) {
			if ($context['use_graphic_library'])
      $verification .= '<img src="'. $verify_context['image_href']. '" alt="'. $txt['visual_verification_description']. '" id="verification_image_'. $verify_id. '" />';
			else
				$verification .= '
				<img src="'. $verify_context['image_href']. ';letter=1" alt="'. $txt['visual_verification_description']. '" id="verification_image_'. $verify_id. '_1" />
				<img src="'. $verify_context['image_href']. ';letter=2" alt="'. $txt['visual_verification_description']. '" id="verification_image_'. $verify_id. '_2" />
				<img src="'. $verify_context['image_href']. ';letter=3" alt="'. $txt['visual_verification_description']. '" id="verification_image_'. $verify_id. '_3" />
				<img src="'. $verify_context['image_href']. ';letter=4" alt="'. $txt['visual_verification_description']. '" id="verification_image_'. $verify_id. '_4" />
				<img src="'. $verify_context['image_href']. ';letter=5" alt="'. $txt['visual_verification_description']. '" id="verification_image_'. $verify_id. '_5" />
				<img src="'. $verify_context['image_href']. ';letter=6" alt="'. $txt['visual_verification_description']. '" id="verification_image_'. $verify_id. '_6" />';

			if (WIRELESS)
      $verification .= '<br />
      <input type="text" name="'. $verify_id. '_vv[code]" value="'. !empty($verify_context['text_value']) ? $verify_context['text_value'] : ''. '" size="30" tabindex="'. $context['tabindex']++. '" class="input_text" />';
      else
      $verification .= '
        <div class="smalltext" style="margin: 4px 0 8px 0;">
          <a href="'. $verify_context['image_href']. ';sound" id="visual_verification_'. $verify_id. '_sound" rel="nofollow">'. $txt['visual_verification_sound']. '</a> / <a href="#" id="visual_verification_'. $verify_id. '_refresh">'. $txt['visual_verification_request_new']. '</a>'. $display_type != 'quick_reply' ? '<br />' : ''. '<br />
          '. $txt['visual_verification_description']. ':'. $display_type != 'quick_reply' ? '<br />' : ''. '
          <input type="text" name="'. $verify_id. '_vv[code]" value="'. !empty($verify_context['text_value']) ? $verify_context['text_value'] : ''. '" size="30" tabindex="'. $context['tabindex']++. '" class="input_text" />
        </div>';
    } else {
      
			// Where in the question array is this question?
			$qIndex = $verify_context['show_visual'] ? $i - 1 : $i;

      $verification .= '
      <div class="smalltext">
        '. $verify_context['questions'][$qIndex]['q']. ':<br />
        <input type="text" name="'. $verify_id. '_vv[q]['. $verify_context['questions'][$qIndex]['id']. ']" size="30" value="'. $verify_context['questions'][$qIndex]['a']. '" '. $verify_context['questions'][$qIndex]['is_error'] ? 'style="border: 1px red solid;"' : ''. ' tabindex="'. $context['tabindex']++. '" class="input_text" />
      </div>';
  }
    
    // If we were displaying just one and we did it, break
    if ($displayType == 'single' && $verify_context['tracking'] == $i) {
      break;
    }
  }
  
  // Assume we found something, always
  $verify_context['tracking']++;
  
  return $verification;
}

function template_control_richedit_buttons($editor_id) {
}

?>
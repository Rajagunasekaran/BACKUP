/*<![CDATA[ */ 

var _screencastPositions = {
    "intro": 0,
    "variables": 1*60+31,
    "file-content": 2*60+20,
    "permissions": 3*60+32,
    "color-labels": 3*60+50,
    "organizing": 4*60+07,	
    "activating": 4*60+38,
    "thank-you": 6*60+02,
};


function vid_jump(jump_position)
{

    document.getElementById('video').currentTime=_screencastPositions[jump_position];
    document.getElementById('video').play();
}

/* ]]> */
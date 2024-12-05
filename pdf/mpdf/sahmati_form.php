<?php

$html = '
            <style>
                ol,td,th{text-align:center}body{font-size:17px;letter-spacing:1px;text-align:justify}body,div,p,td{font-family:freesans}.title-container{display:flex;flex-direction:column;align-items:center;justify-content:center}.fw-600{font-weight:600}table,td,th{border-collapse:collapse;border:1px solid #000}td,th{padding:2px}td{overflow:hidden;height:50px}.lt-container,.table-container{margin-bottom:30px}@media (max-width:768px){.lt-container{padding:2% 5%}td,th{font-size:14px;padding:5px}td{overflow:hidden;height:50px}}@media (max-width:480px){body{font-size:15px}.lt-container{padding:5%}td,th{font-size:12px;padding:3px}td{overflow:hidden;height:50px}.title-container{text-align:center}table{width:100%;display:block;overflow-x:auto}}@media (max-width:320px){body{font-size:14px}.lt-container{padding:10px}td,th{font-size:10px;padding:2px}td{overflow:hidden;height:50px}}
            </style>
            <body>
            <div class="lt-container">

                <div style="text-align:center;font-weight:bold">
                    <div class="lt-title">प्रारूप संख्या-1</div>
                    <div class="ext-title">भूस्वामी/भूस्वामियों और क्रय निकाय के बीच लोक प्रयोजनों के लिए समझौते द्वाराभूमि क्रय किये जाने हेतु निष्पादित किया जाने वाला समझौता प्रमाण पत्र।</div>
                </div>

                <div class="cntr-2">
                    <p>यह समझौता पत्र आज दिनांक ' . date('d-m-Y', time()) . ' वर्ष ' . date('Y', time()) . ' को निम्न भूस्वामी/भूस्वामियों जो सम्पत्ति का/के पूर्ण स्वामी है/हैं जिसे आगे उल्लिखित किया गया है और निम्नलिखित अंशो में एतद्द्वारा वर्णित किया गया है, अर्थात</p>
                        ';

$html .= '<p><span style="font-weight:bold">1) </span> ' . $owner_name . ' <span style="font-weight:bold">पति/पिता श्री</span> ' . $owner_father . ' <span style="font-weight:bold">अंश</span> ' . $ansh . '</p>';

$html .= '  <p style="font-weight:bold">प्रथम पक्ष (जिसे एतद्रपश्चात ’’भूस्वामी’’ कहा गया है) और;</p>
                <p>उत्तर प्रदेश के श्री राज्यपाल/राज्य सरकार के माध्यम से कार्य कर रहे-</p>
                <p style="font-weight:bold">बुन्देलखण्ड औद्योगिक विकास प्राधिकरण </p>
                <p style="font-weight:bold">द्वितीय पक्ष (जिसे एतद्रपश्चात ’’क्रय निकाय’’ कहा गया है) के मध्य एतद्द्वारा हस्ताक्षरित/निष्पादित किया गया है-</p>
                <p>चूंकि उल्लिखित पक्षकार भूमि के सापेक्ष देय दर तथा कुल भूमि मूल्य पर सहमत है/हैं जिसका विवरण अनुसूची में दिया गया है,
                    और चूंकि भूस्वामी अग्रेतर सहमत है/हैं कि अनुसूची में वर्णित भूबद्ध कोई बात या भूबद्ध किसी चीज से अस्थाई रूप से सम्बद्ध सभी बातें क्रय निकाय के पूर्व अनुमोदन से वापस ली जा सकेगी।
                    अतएव अब भूस्वामी और क्रय निकाय से एतद्द्वारा निम्न प्रकार सहमत होता/होते हैः-
                </p>
                <p>(1) यह कि क्रय निकाय इस समझौता पत्र के निष्पादन की तिथि से अधिकतम 12 माह के भीतर अनिवार्य अर्जन के बिना, कार्यवाही करने में सक्षम होगा।</p>
                <p>(2) यह कि यदि क्रय निकाय भूमि का तुरन्त कब्जा लेना आवश्यक समझता है तो वह/वे ऐसा करने का हकदार होगा/होंगे, भले ही इस पर फसल खड़ी हो, परन्तु यह कि अनुसूची में वर्णित ’’दर और कुल भूमि मूल्य’’ का भुगतान कर दिया हो।</p>
                <p>(3) यह कि यदि कुल भूमि में मूल्य मे भुगतान के पश्चात यह प्रकट होता है कि भूमिस्वामी इस समझौता पत्र में निष्पादित विक्रय विलेख के अनुसार प्रतिकर की सम्पूर्ण धनराशि का/के अन्यन्य रूप से हकदार नहीं है/हैं और क्रय निकाय की ओर से किसी अन्य व्यक्ति को किसी प्रतिकर का भुगतान करने की अपेक्षा की जाती है तो भूस्वामी द्वारा ऐसी धनराशि, जो क्रय निकाय द्वारा अवधारित की जाये, मांग किये जाने पर वापस कर देगा। और किसी अन्य व्यक्ति/व्यक्तियों द्वारा किसी दावे या प्रतिकर या उसके भाग के विरूद्व क्रय निकाय/राज्य सरकार को (संयुक्तः और पृथकतः) क्षतिपूर्ति करेगा और उठायी गयी किसी हानि या नुकसान की सभी कार्यवाहियों और दायित्वों के विरूद्व उसे/उनको भुगतान के कारण क्रय निकाय द्वारा उपगत किसी लागत प्रभार या क्रय की गयी धनराशि पर विरूद्व उसे/उनकों भुगतान के कारण क्रय निकाय द्वारा उपगत किसी लागत प्रभार या व्यय की गयी धनराशि पर प्रथम वर्ष 9 प्रतिशत की दर पर और पश्चातवर्ती वर्षों के लिए 15 प्रतिशत की दर पर व्याज भुगतान करेगा/करेगें।</p>
                <p>(4) यदि भूस्वामी पूर्ववर्ती पैरा में उल्लिखित धनराशि क्रय निकाय को वापस करने में असफल रहता है/रहते हैं। तो क्रय निकाय को कलेक्टर के माध्यम से उसे भू-राजस्व के बकाये के रूप में वसूल करने या ऐसी धनराशि को वसूली के लिए प्रवृत्त किसी विधि के अधीन कार्यवाही करने का/देने का पूरा अधिकार होगा।</p>
                <p>(5) यदि अनुसूची में वर्णित भूमि पर कोई सरकारी देय/अंश/प्रीमियम भूस्वामी द्वारा देय है या किसी वित्तीय संस्था का ऋण उक्त भूमि के विरूद्व वकाया है तो उस धनराशि को कुल भूमि मूल्य की धनराशि से कटौती करके शेष धनराशि का भुगतान भू-स्वामी को किया जायेगा।</p>
                <p>(6) क्रय निकाय और भू-स्वामी के मध्य हस्ताक्षरित इस समझौता पत्र के अनुमोदन के उपरान्त आवश्यक विक्रय विलेख का निष्पादन किया जाएगा, जिसके पंजीकरण/निबन्धन सम्बन्धी समस्त शुल्क, जिसमें स्टाम्प शुल्क भी सम्मिलित होता है, को क्रय निकाय द्वारा व्यय वहन किया जाएगा।</p>
                <p>(7) विक्रय विलेख के निष्पादन के दिनांक पर ही सम्बन्धित भू-स्वामी से अनुसूची-1 में वर्णित भूमि का कब्जा क्रय निकाय द्वारा प्राप्त किया जाता है।</p>
                <p>(8) क्रय निकाय के द्वारा निम्नलिखित आधारों पर इस समझौता पत्र को भू-स्वामी को 15 दिन का नोटिस देकर निरस्त किया जा सकेगाः-</p>
                <p>(क) यदि भूस्वामी ने समझौता पत्र को कपटपूर्ण व्यवहार करके सम्पादित कराया है,</p>
                <p>(ख) यदि भूस्वामी के द्वारा समझौता पत्र के किसी शर्त का उल्लंघन किया जाता है,</p>
                <p>(ग) यदि इस समझौता पत्र के निष्पादन के उपरान्त यह प्रकट होता है कि अनुसूची-1 में वर्णित भूमि का स्वामित्व भू-स्वामी में नहीं है। </p>
            </div>

            <div class="table-container">

                <div style="text-align:center;font-weight:bold">अनुसूची</div>
                <div style="width:100%"><div style="float: left;width:25%;">ग्राम </div><div style="float: left;width:25%;">परगना </div><div style="float: left;width:25%;">तहसील- झाँसी</div><div style="float: left;">जिला- झाँसी</div>
            <div style="clear:both"></div>
            </div>
                <table>
                    <caption></caption>
                    <tr>
                        <th rowspan="2">खाता सं0</th>
                        <th rowspan="2">खसरा सं0</th>
                        <th rowspan="2">क्षेत्रफल हे0 मे</th>
                        <th rowspan="2">भूमि का विवरण, यदि वह सर्वेक्षण संख्या का भाग हो (चारों सीमाओ और लगी हुई भूस्वामी का स्वामित्व प्रदर्शित करते हुए)</th>
                        <th rowspan="2">भूमि के कुल मूल्य के लिए निर्धारित दर (रू0 में)</th>
                        <th colspan="2">भूमि पर खड़ी फसल</th>
                    </tr>
                    <tr>
                        <th>विवरण</th>
                        <th>मूल्यांकन के अनुसार देय राशि (रू0 में)</th>
                    </tr>
                    ';
$html .= '<tr>
                    <td>' . $khata_no . '</td>
                    <td>' . $gata_no . '</td>
                    <td>' . $gata_area . '</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            ';

$html .= '</table>
                </div>

                <div class="table-container">
                    <table style="width: 100%;">
                        <caption></caption>
                        <tr>
                            <th colspan="2">भूबद्ध अन्य सम्पत्ति का विवरण</th>
                            <th rowspan="2">देय कुल मूल्य (योग कालम-7,8,9)</th>
                            <th rowspan="2">व्यक्ति/व्यक्तियों का/के नाम और पता जिनको देय हैं और उनका परिमाण विवरण</th>
                        </tr>
                        <tr>
                            <th>विवरण</th>
                            <th>मूल्यांकन के अनुसार देय राशि (रू0 में)</th>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                </div>

                <div style="width:100%;">
                    <div style="float:left;width:65%; ">भूस्वामी/ भूस्वामियों के हस्ताक्षर</div>
                    <div style="float:right">क्रय निकाय की ओर से अधिकृत अधिकारी हस्ताक्षर</div>
                    <div style="clear:both"></div>
                </div>
                <div>
                   <div>1-	</div>
                   <div style="width:100%"><div style="float: left;width:45%">2-</div> <div style="float:right">पूरा नाम</div></div>
                   <div style="clear:both"></div>
                   <div><div style="float: left;width:45%">3-</div> <div style="float:left">पद नाम</div></div>
                   <div style="clear:both"></div>
                </div>
                <div style="width:100%;">
                <div style="float:left;width:65%;">गवाह/अभिसाक्षी</div>
                    <div style="float:right"> गवाह/अभिसाक्षी</div>
                    <div style="clear:both"></div>
                </div>

            </div>
            </body>
        ';

$mpdf = new \Mpdf\Mpdf();

$mpdf->autoScriptToLang = true;
$mpdf->baseScript = 1;
$mpdf->autoLangToFont = true;

$mpdf->WriteHTML($html);

$mpdf->Output($target_dir . $filename, 'F');

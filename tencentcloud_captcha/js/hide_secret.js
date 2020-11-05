/**
 * Copyright (C) 2020 Tencent Cloud.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

(function ($) {
  $("input[name='tc_secret_id']").blur(function (){
    $(this).attr('type','password');
  });
  $("input[name='tc_secret_id']").focus(function (){
    $(this).attr('type','text');
  });

  $("input[name='tc_secret_key']").blur(function (){
    $(this).attr('type','password');
  });
  $("input[name='tc_secret_key']").focus(function (){
    $(this).attr('type','text');
  });
})(jQuery);

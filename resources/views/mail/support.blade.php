@include('mail.mailheader')


               {{-- <tr>
                  <td height="30"></td>
              </tr> --}}
              <tr> 
                  <td style="padding-bottom: 15px; padding-top:15px; border-top: 1px solid #e4e4e4;">
                    <p style="font-family: Helvetica, sans-serif; font-size: 17px; font-weight: normal; margin: 0; margin-bottom: 16px;">Dear {{$maildata['name']}},</p>
                    <p style="font-family: Helvetica, sans-serif; font-size: 17px; font-weight: normal; margin: 0; margin-bottom: 16px; margin-top: 10px;">Thank you for reaching out to us. We acknowledge your query and appreciate your participation. Rest assured, one of our support executives will be in touch with you within 24 hours to address your concerns. We appreciate your patience during this process.</p>
                    <p style="font-family: Helvetica, sans-serif; font-size: 17px; font-weight: normal; margin: 0; margin-bottom: 16px; margin-top: 10px;">Please find below the details of your query for your reference:</p>

                    <p>•	Reference No:  {{$maildata['ref_no']}}</p>
                    <p>•	Site Name: {{$maildata['site_name']}}</p>
                    <p>•	Client ID: {{$maildata['client_id']}}</p>
                    <p>•	subject: {{$maildata['Subject']}}</p>
                    <p>•	Message: {{$maildata['message']}}</p>
                    <p>•	Date of Submission: {{$maildata['date']}}</p>

                  </td>   
              </tr>
              {{-- <tr>
                  <td height="20">
                    <p>To access Sprinters Online and start enjoying our games and contests, download our app:</p>
                    <p>App Store Download Link : {{optional(DB::table('app_infos')->first())->appstore_url}} </p>
                    <p>Google Play Download Link : {{optional(DB::table('app_infos')->first())->playstore_url}} </p>
                  </td>
              </tr> --}}
            
              
               <tr>
                  <td height="20"></td>
              </tr>
              
              @include('mail.mailfooter')
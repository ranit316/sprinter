@include('mail.mailheader')


               {{-- <tr>
                  <td height="30"></td>
              </tr> --}}
              <tr> 
                  <td style="padding-bottom: 15px; padding-top:15px; border-top: 1px solid #e4e4e4;">
                    <p style="font-family: Helvetica, sans-serif; font-size: 17px; font-weight: normal; margin: 0; margin-bottom: 16px;">Dear {{$maildata['name']}},</p>
                    <p style="font-family: Helvetica, sans-serif; font-size: 17px; font-weight: normal; margin: 0; margin-bottom: 16px; margin-top: 10px;">Congratulations on creating your account with Sprinters Online!</p>
                    <p style="font-family: Helvetica, sans-serif; font-size: 17px; font-weight: normal; margin: 0; margin-bottom: 16px; margin-top: 10px;">Your account details:</p>
                    <p>•	Email ID: {{$maildata['email']}}</p>
                    <p>•	Password: {{$maildata['password']}}</p>
                  </td>   
              </tr>
              <tr>
                  <td height="20">
                    <p>To access Sprinters Online and start enjoying our games and contests, download our app:</p>
                    <p>App Store Download Link : {{optional(DB::table('app_infos')->first())->appstore_url}} </p>
                    <p>Google Play Download Link : {{optional(DB::table('app_infos')->first())->playstore_url}} </p>
                  </td>
              </tr>
              <tr>
                  
            <td>
              <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
                <tbody>
                  <tr>
                    <td height="10" colspan="4">
                       <p> For any queries or assistance, visit our support page: {{optional(DB::table('cms_pages')->where('title','Get Support')->first())->description}} </p>
                    </td>
                  </tr>
                  {{-- <tr>
                    <td style="font-size: 14px; font-family: 'Open Sans', sans-serif; color: #1a1919; line-height: 23px; vertical-align: top; padding:10px; border-bottom: 1px solid #e4e4e4;" class="article">
                      <strong>Username:</strong>
                    </td>   
                      <td style="font-size: 14px; font-family: 'Open Sans', sans-serif; color: #1a1919;  line-height: 23px;  vertical-align: top; padding:10px; border-bottom: 1px solid #e4e4e4;" align="right">{{$maildata['name']}}</td>
                  </tr> --}}
                </tbody>
              </table>
            </td>
          </tr>
              
               <tr>
                  <td height="20"></td>
              </tr>
              
              @include('mail.mailfooter');
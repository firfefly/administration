<li class="test"><a  href="{{path('fos_user_change_password')}}"><span class="fas fa-sign-in-alt"></span> chgmnt mdp</a></li>
        <li class="test"><a  href="{{path('fos_user_resetting_request')}}"><span class="fas fa-sign-in-alt"></span> reset mdp</a></li>
        <li class="test"><a  href="{{path('fos_user_profile_edit')}}"><span class="fas fa-sign-in-alt"></span> edit profile</a></li>
        {% if is_granted('ROLE_ADMIN') is same as(true) %}
            <li class="registration"><a  href="{{path('fos_user_registration_register')}}"><span class="fas fa-sign-in-alt"></span> Inscription</a></li>
        {% endif %}
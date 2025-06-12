jQuery(document).ready(function ($) {
    
    $(".il_team_member.il_member_has_learn_more .member_image").click(function () {
        $(".il_team_member.il_member_has_learn_more .member_image").parent().not(this).next(".member_text.t-open").slideToggle().removeClass('t-open');
        $(this).parent().next(".member_text").slideToggle().toggleClass('t-open');
    });
    $(".member_text .close").click(function () {
        $(this).parents('.member_text').slideToggle().removeClass('t-open');
    });

});
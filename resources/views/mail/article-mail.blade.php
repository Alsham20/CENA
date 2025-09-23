@extends('mail.base')
@section('body')
<table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
    <!-- Body content -->
    <tr>
       <td class="content-cell">
          <h3>NOUVEL ARTICLE EN ATTENTE DE PUBLICATION</h3>
          <p></p>
          <table class="action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
             <tr>
                <td align="">
                   L'article <b>{{$article->title}}</b> est en attente de publication. <br>
                   Merci de consulter l'article pour la revue en cliquant sur le bouton ci-dessous
                </td>
             </tr>
             <tr>
                <td align="center">
                    <div class="button-container" style="text-align: center; margin-top: 20px; margin-bottom: 20px;"><a href="{{route('articles.edit',['article'=>$article->id])}}" class="button" style="display: inline-block; background-color: #007bff; color: #ffffff; padding: 10px 20px;
                        border-radius: 0px; text-decoration: none; font-size: 16px; font-weight: 700;">Consulter l'article</a></div>
                </td>
             </tr>
          </table>
          <p>Cordialement,</p>
       </td>
    </tr>
</table>
@endsection

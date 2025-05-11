<!-- 댓글 입력 폼 추가 -->
<form method="post" action="add_comment.php">
    <textarea name="comment_text" placeholder="댓글을 입력하세요"></textarea>
    <input type="hidden" name="post_id" value="<?php echo $id; ?>">
    <input type="submit" value="댓글 추가">
</form>

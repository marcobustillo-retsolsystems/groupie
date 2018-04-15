<?php
class discussionmodel extends CI_Model{

	function getPosts($postid){
		$query = $this->db->select('post_content
								  , post_picture
								  , post_date
								  , post_file
								  , post_filename
								  , tbl_accounts.accounts_fname
								  , tbl_accounts.accounts_lname
								  , tbl_accounts.accounts_picture')
						  ->from('tbl_post,tbl_accounts')
						  ->where('post_ID',$postid)
						  ->where('tbl_post.account_ID = tbl_accounts.account_ID')
						  ->get();
		return $query->result();
	}
	function getComments($postid){
		$query = $this->db->select('comments_content
								  , comments_date
								  , tbl_accounts.accounts_fname
								  , tbl_accounts.accounts_lname
								  , tbl_accounts.accounts_picture')
						 ->from('tbl_comments,tbl_accounts')
						 ->where('post_ID',$postid)
						 ->where('tbl_comments.account_ID = tbl_accounts.account_ID')
						 ->get();
		return $query->result();
	}

	function addComment($postid,$userid,$comment,$date){
		$this->db->set('post_ID',$postid)
				 ->set('account_ID',$userid)
				 ->set('comments_content',$comment)
				 ->set('comments_date',$date)
				 ->insert('tbl_comments');
	}

	function getType($userid){
		$query = $this->db->select('accounts_type')
						  ->from('tbl_accounts')
						  ->where('account_ID',$userid)
						  ->get();
		$query_row = $query->row();

        return $query_row->accounts_type;

	}
}
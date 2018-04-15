<?php
class newsfeedmodel extends CI_Model{
	
	function getPost($userid){	
		$query = $this->db->select('accounts_fname
								, accounts_lname
								, tbl_post.post_content
								, tbl_post.post_date
								, tbl_groups.groups_Name
								, tbl_groups.groups_ID
								, accounts_picture
								, tbl_post.post_picture
								, tbl_post.post_file
								, tbl_post.post_filename
								, tbl_post.post_ID')
							->from('tbl_post
								, tbl_groups_member
								, tbl_accounts
								, tbl_groups')
							->where('tbl_groups_member.accounts_ID', $userid)
							->where('tbl_post.post_approve',1)
							->where('tbl_post.groups_id = tbl_groups_member.groups_id')
							->where('tbl_post.account_ID = tbl_accounts.account_ID')
							->where('tbl_post.groups_ID = tbl_groups.groups_ID')
							->order_by('post_date','desc')
							->get();

		return $query->result();
	}

	function updatePassword($id,$newpassword){
		$data = array(
			'password' => $newpassword
			);
		$this->db->where('account_ID',$id);
		$this->db->update('tbl_accounts',$data);
	}
}

?>
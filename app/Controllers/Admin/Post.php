<?php

namespace App\Controllers\Admin;

use \App\Controllers\BaseController;
use App\Models\PostModel;

/**
 * Class for handling the creation and deletion of posts.
 */
class Post extends BaseController {
	protected PostModel $posts;

	/**
	 * Sets up the PostModel.
	 */
	public function __construct() {
		helper('form');
		$this->posts = new PostModel();
	}

	/**
	 * Displays a lists of posts.
	 */
	public function index() {
		$data = [
			'posts' => $this->posts->findAll(),
		];
		return view('admin/posts', $data);
	}

	/**
	 * Adds a post to the DB.
	 */
	public function addPost() {
		$data = $this->request->getPost();
		$post = new Post($data);
		if ($this->posts->save($data)){
			return redirect()->back()->with('success', 'Post is toegevoegd');
		}

		return redirect()->back()->with('error', 'De post kon niet worden toegevoegd');
	}

	/**
	 * Deletes a post from the DB.
	 */
	public function deletePost(int $id) {
		if ($this->posts->delete($id)){
			return redirect()->back()->with('success', 'Post is verwijderd');
		}
		return redirect()->back()->with('error', 'De post kon niet worden verwijderd');
	}
}

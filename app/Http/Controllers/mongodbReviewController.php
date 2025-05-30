<?php

// namespace App\Http\Controllers;

// use App\Models\mongodbReview;
// use App\Models\Order;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Storage;

// class mongodbReviewController extends Controller
// {
//     // Show form to create a review for a specific order
//     public function create($order_id)
//     {
//         $order = Order::findOrFail($order_id);

//         // Prevent duplicate reviews
//         $existingReview = mongodbReview::where('order_id', $order_id)
//             ->where('user_id', Auth::id())
//             ->first();

//         if ($existingReview) {
//             return redirect()->route('customer.mongodbReviews.show', $existingReview->_id);
//         }

//         return view('customer.mongodbReviews.create', compact('order'));
//     }

//     // Store review data
//     public function store(Request $request)
//     {
//         $request->validate([
//             'order_id' => 'required|exists:orders,id',
//             'rating' => 'required|integer|between:1,5',
//             'comment' => 'required|string|max:1000',
//             'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
//         ]);

//         $imagePaths = [];
//         if ($request->hasFile('images')) {
//             foreach ($request->file('images') as $image) {
//                 $path = $image->store('review_images', 'public');
//                 $imagePaths[] = $path;
//             }
//         }

//         $review = mongodbReview::create([
//             'user_id' => Auth::id(),
//             'order_id' => $request->order_id,
//             'rating' => $request->rating,
//             'comment' => $request->comment,
//             'images' => $imagePaths
//         ]);

//         return redirect()->route('customer.mongodbReviews.show', $review->_id)
//             ->with('success', 'Thank you for your review!');
//     }

//     // Show a single review
//     public function show($id)
//     {
//         $review = mongodbReview::findOrFail($id);
//         $user = \App\Models\User::find($review->user_id);
//         $order = Order::find($review->order_id);

//         return view('customer.mongodbReviews.show', compact('review', 'user', 'order'));
//     }

//     // ✅ Show all reviews of the logged-in user
//     public function index()
//     {
//         $reviews = mongodbReview::where('user_id', Auth::id())->latest()->get();
//         return view('customer.mongodbReviews.show', compact('reviews'));
//     }

//     // ✅ Delete a review
//     public function destroy($id)
//     {
//         $review = mongodbReview::findOrFail($id);

//         // Authorization check
//         if ($review->user_id != Auth::id()) {
//             return redirect()->back()->with('error', 'Unauthorized action.');
//         }

//         // Delete review images from storage
//         if (!empty($review->images)) {
//             foreach ($review->images as $image) {
//                 Storage::disk('public')->delete($image);
//             }
//         }

//         $review->delete();

//         return redirect()->route('customer.product')->with('success', 'Review deleted successfully.');
//     }

//     public function update(Request $request, $id)
//     {
//         $request->validate([
//             'rating' => 'required|integer|between:1,5',
//             'comment' => 'required|string|max:1000',
//         ]);

//         $review = mongodbReview::findOrFail($id);

//         if ($review->user_id != Auth::id()) {
//             return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
//         }

//         $review->rating = $request->rating;
//         $review->comment = $request->comment;
//         $review->save();

//         return redirect()->route('customer.mongodbReviews.show', $review->_id)
//             ->with('success', 'Review updated successfully');
//     }
//     public function edit($id)
//     {
//         $review = mongodbReview::findOrFail($id);

//         // Authorization check
//         if ($review->user_id != Auth::id()) {
//             return redirect()->back()->with('error', 'Unauthorized action.');
//         }

//         return view('customer.mongodbReviews.edit', compact('review'));
//     }
// }

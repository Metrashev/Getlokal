<div class="container set-over-slider">
	<div class="row">

		<div class="container">
			<div class="row">
				<h1 class="col-xs-12 main-form-title">Main Title</h1>
				<p class="col-xs-12 main-form-description">Here we can add some really really helpful description about this form.</p>
			</div>
		</div>
          
	</div>
	<div class="row"><!--  -->
		<div class="default-container default-form-wrapper col-sm-12">


<!-- ########################## MESSAGES ########################## -->


			<div class="form-message error">
				There is missing info and/or errors. Please check again!
			</div><!-- ERROR MSG -->

			<div class="form-message success">
				Oh Yeah ! You did it !
			</div><!-- SUCCESS MSG -->


<!-- ########################## END MESSAGES ########################## -->

<!-- ########################## FORM  ########################## -->

			<form action="#" method="get" class="default-form clearfix">

				<h2 class="form-title">Different sizes of inputs</h2> <!-- Form Title -->

				<p class="form-description">
					In <strong>"_global.less"</strong> file we have predefined <em>global classses</em> for input states and types.<a href="#">Here is how link will look.</a>
				</p><!-- Form Description -->

				<div class="row">
					<div class="col-sm-2">
						<div class="default-input-wrapper active incorrect">
							<div class="required-txt">Required</div>
							<div class="error-txt">Error text goes here</div>
							<label for="name" class="default-label">Label text</label>
							<input type="text" placeholder="Placeholder text" id="name" class="default-input">
						</div><!-- Form Default Input -->
					</div>
					<div class="col-sm-3">
						<div class="default-input-wrapper active">
							<div class="required-txt">Required</div>
							<div class="error-txt">Error text goes here</div>
							<label for="name" class="default-label">Label text</label>
							<input type="text" placeholder="Placeholder text" id="name" class="default-input">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="default-input-wrapper active required">
							<div class="required-txt">Required</div>
							<div class="error-txt">Error text goes here</div>
							<label for="name" class="default-label">Label text</label>
							<input type="text" placeholder="Placeholder text" id="name" class="default-input">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-1">
						<div class="default-input-wrapper">
							<div class="required-txt">Required</div>
							<div class="error-txt">Error text goes here</div>
							<label for="name" class="default-label">Label text</label>
							<input type="text" placeholder="Placeholder text" id="name" class="default-input">
						</div>
					</div>
					<div class="col-sm-5">
						<div class="default-input-wrapper required">
							<div class="required-txt">Required</div>
							<div class="error-txt">Error text goes here</div>
							<label for="name" class="default-label">Label text</label>
							<input type="text" placeholder="Placeholder text" id="name" class="default-input">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="default-input-wrapper info">
							<div class="required-txt">Required</div>
							<div class="error-txt">Error text goes here</div>
							<label for="name" class="default-label">Label text</label>
							<input type="text" placeholder="Placeholder text" id="name" class="default-input">
						</div>
						<ul class="tag-wrapper">
							<li class="tag">some tag <i class="close"></i> </li>
							<li class="tag">some very big tag <i class="close"></i></li>
							<li class="tag">some <i class="close"></i></li>
							<li class="tag">some tag <i class="close"></i> </li>
						</ul><!-- Form Tags -->
					</div>
				</div>

				<h2 class="form-title">Input type File</h2>

				<div class="row">
					<div class="col-sm-6">

						<div class="file-input-wrapper">
							<label for="fileUpload" class="file-label">
								No File chosen
								<input type="file" placeholder="Caption" id="fileUpload" class="file-input">
							</label>
						</div><!-- Form FileUpload -->

					</div>
				</div>

				<h2 class="form-title">Text Area</h2>

				<div class="row">
					<div class="col-sm-12">
						<div class="default-input-wrapper required">
							<div class="required-txt">Required</div>
							<div class="error-txt">Error text goes here</div>
							<label for="town" class="default-label">City/Town</label>
							<textarea placeholder="Placeholder text" class="default-input"></textarea>
						</div><!-- Form TextArea -->
					</div>
				</div>

				<h2 class="form-title">Select</h2>

				<div class="row">
					<div class="col-sm-12">

						<div class="default-input-wrapper select-wrapper">
							<div class="required-txt">Required</div>
							<div class="error-txt">Error text goes here</div>
							<label for="town" class="default-label">City/Town</label>
							<select class="default-input">
								<option value="Option 01">Option 01</option>
								<option value="Option 02">Option 02</option>
								<option value="Option 03">Option 03</option>
								<option value="Option 04">Option 04</option>
							</select>
						</div><!-- Form Select -->

					</div>
				</div>


				<h2 class="form-title">Tabs</h2>

				<div class="row">
					<div class="col-sm-12">

					<!-- Form Tabs -->

					<ul class="nav nav-tabs default-form-tabs" role="tablist" id="myTab">
						<li class="active"><a href="#Section01" role="tab" data-toggle="tab">Section01</a></li>
						<li><a href="#Section02" role="tab" data-toggle="tab">Section02</a></li>
						<li><a href="#Section03" role="tab" data-toggle="tab">Section03</a></li>
						<li><a href="#Section04" role="tab" data-toggle="tab">Section04</a></li>
					</ul>

					<div class="tab-content default-form-tabs-content">
						<div class="tab-pane active" id="Section01">Text 01</div>
						<div class="tab-pane" id="Section02">Text 02</div>
						<div class="tab-pane" id="Section03">Text 03</div>
						<div class="tab-pane" id="Section04">Text 04</div>
					</div>

					<!-- END Form Tabs -->

					</div>
				</div>
				
				<h2 class="form-title">Checkboxes</h2>


				<div class="row margin-bottom">
					<div class="col-sm-4">

						<div class="custom-row">
							<div class="default-checkbox">
								<input type="checkbox" value="None" id="Checkbox01" name="check" checked />
								<div class="fake-box"></div>
							</div>
							<label for="Checkbox01" class="default-checkbox-label">Label Text Goes Here</label>
						</div><!-- Form Checkbox -->

						<div class="custom-row">
							<div class="default-checkbox">
								<input type="checkbox" value="None" id="Checkbox02" name="check"/>
								<div class="fake-box"></div>
							</div>
							<label for="Checkbox02" class="default-checkbox-label">Label Text Goes Here</label>
						</div><!-- Form Checkbox -->

						<div class="custom-row">
							<div class="default-checkbox">
								<input type="checkbox" value="None" id="Checkbox03" name="check" checked />
								<div class="fake-box"></div>
							</div>
							<label for="Checkbox03" class="default-checkbox-label">Label Text Goes Here</label>
						</div><!-- Form Checkbox -->

						<div class="custom-row">
							<div class="default-checkbox">
								<input type="checkbox" value="None" id="Checkbox04" name="check"/>
								<div class="fake-box"></div>
							</div>
							<label for="Checkbox04" class="default-checkbox-label">Label Text Goes Here</label>
						</div><!-- Form Checkbox -->

					</div>
				</div>	

				<h2 class="form-title">Radio Buttons</h2>


				<div class="row margin-bottom">
					<div class="col-sm-12">
					
						<div class="custom-row">
							<div class="default-radio">
								<input type="radio" id="radio1" name="name" />
								<div class="fake-box"></div>
							</div>
							<label for="radio1" class="default-radio-label">Button 1</label>
						</div>	

						<div class="custom-row">
							<div class="default-radio">
								<input type="radio" id="radio2" name="name" />
								<div class="fake-box"></div>
							</div>
							<label for="radio2" class="default-radio-label">Button 2</label>
						</div>	

						<div class="custom-row">
							<div class="default-radio">
								<input type="radio" id="radio3" name="name" />
								<div class="fake-box"></div>
							</div>
							<label for="radio3" class="default-radio-label">Button 3</label>
						</div>	

						<div class="custom-row">
							<div class="default-radio">
								<input type="radio" id="radio4" name="name" />
								<div class="fake-box"></div>
							</div>
							<label for="radio4" class="default-radio-label">Button 4</label>
						</div>


					</div>
				</div>

				<h2 class="form-title">Radio Buttons - STARS</h2>


				<div class="row margin-bottom">
					<div class="col-sm-12">
					
						<div class="custom-row">
							<div class="default-radio star active">
								<input type="radio" id="star1" name="name" />
								<div class="fake-box"></div>
							</div>

							<div class="default-radio star">
								<input type="radio" id="star2" name="name" />
								<div class="fake-box"></div>
							</div>

							<div class="default-radio star">
								<input type="radio" id="star3" name="name" />
								<div class="fake-box"></div>
							</div>	
							<div class="default-radio star">
								<input type="radio" id="star4" name="name" checked="checked" />
								<div class="fake-box"></div>
							</div>	
							<div class="default-radio star">
								<input type="radio" id="star5" name="name" />
								<div class="fake-box"></div>
							</div>
						</div><!-- Stars -->

					</div>
				</div>

				<h2 class="form-title">Show more or less Bar</h2>

				<div class="row">
					<div class="col-sm-12">
						<div class="custom-row toggle-row show-more">
							<div class="center-block txt-more">
								<i class="fa fa-angle-double-down fa-lg"></i>
								<span>Покажи още</span>
								<i class="fa fa-angle-double-down fa-lg"></i>
							</div>

							<div class="center-block txt-less">
								<i class="fa fa-angle-double-up fa-lg"></i>
								<span>Покажи по-малко</span>
								<i class="fa fa-angle-double-up fa-lg"></i>
							</div>
						</div><!-- Form Show-more-less Bar -->
					</div>
				</div>


				<h2 class="form-title">Scrollable container</h2>

				<div class="row margin-bottom">
					<div class="col-sm-4 scrollable-container">

						<div class="custom-row">
							<div class="default-checkbox">
								<input type="checkbox" value="None" id="Checkbox001" name="check" checked />
								<div class="fake-box"></div>
							</div>
							<label for="Checkbox001" class="default-checkbox-label">Label Text Goes Here</label>
						</div><!-- Form Checkbox -->

						<div class="custom-row">
							<div class="default-checkbox">
								<input type="checkbox" value="None" id="Checkbox002" name="check"/>
								<div class="fake-box"></div>
							</div>
							<label for="Checkbox002" class="default-checkbox-label">Label Text Goes Here</label>
						</div><!-- Form Checkbox -->

						<div class="custom-row">
							<div class="default-checkbox">
								<input type="checkbox" value="None" id="Checkbox003" name="check" checked />
								<div class="fake-box"></div>
							</div>
							<label for="Checkbox003" class="default-checkbox-label">Label Text Goes Here</label>
						</div><!-- Form Checkbox -->

						<div class="custom-row">
							<div class="default-checkbox">
								<input type="checkbox" value="None" id="Checkbox004" name="check"/>
								<div class="fake-box"></div>
							</div>
							<label for="Checkbox004" class="default-checkbox-label">Label Text Goes Here</label>
						</div><!-- Form Checkbox -->

						<div class="custom-row">
							<div class="default-checkbox">
								<input type="checkbox" value="None" id="Checkbox005" name="check" checked />
								<div class="fake-box"></div>
							</div>
							<label for="Checkbox005" class="default-checkbox-label">Label Text Goes Here</label>
						</div><!-- Form Checkbox -->

						<div class="custom-row">
							<div class="default-checkbox">
								<input type="checkbox" value="None" id="Checkbox006" name="check"/>
								<div class="fake-box"></div>
							</div>
							<label for="Checkbox006" class="default-checkbox-label">Label Text Goes Here</label>
						</div><!-- Form Checkbox -->

						<div class="custom-row">
							<div class="default-checkbox">
								<input type="checkbox" value="None" id="Checkbox007" name="check" checked />
								<div class="fake-box"></div>
							</div>
							<label for="Checkbox007" class="default-checkbox-label">Label Text Goes Here</label>
						</div><!-- Form Checkbox -->

						<div class="custom-row">
							<div class="default-checkbox">
								<input type="checkbox" value="None" id="Checkbox008" name="check"/>
								<div class="fake-box"></div>
							</div>
							<label for="Checkbox008" class="default-checkbox-label">Label Text Goes Here</label>
						</div><!-- Form Checkbox -->

					</div>
				</div>	

				<div class="row">
					<div class="col-sm-12 form-btn-row">
						<input class="default-btn success pull-right " type="submit" value="Publish">
						<a href="#" class="default-btn pull-right">Back to list</a>
					</div> <!-- Form button row with bigger buttons -->
				</div>
			</form><!-- END default-form -->

        </div><!-- END default-form-wrapper -->
    </div>

</div>